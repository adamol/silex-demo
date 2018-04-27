<?php

namespace Order;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Controller
{
    private $validator;

    private $paymentGateway;

    private $cartRepository;

    private $bookItemRepository;

    private $orderRepository;

    private $mailer;

    private $authenticator;

    public function __construct(
        \Framework\Validator $validator,
        \Order\Payment\PaymentGateway $paymentGateway,
        \Cart\Repository $cartRepository,
        \Books\Item\Repository $bookItemRepository,
        \Order\Repository $orderRepository,
        \Framework\Mailer $mailer,
        \Auth\Authenticator $authenticator
    ) {
        $this->validator = $validator;
        $this->paymentGateway = $paymentGateway;
        $this->cartRepository = $cartRepository;
        $this->bookItemRepository = $bookItemRepository;
        $this->orderRepository = $orderRepository;
        $this->mailer = $mailer;
        $this->authenticator = $authenticator;
    }

    public function show($confirmationNumber)
    {
        $jsonableOrder = $this->orderRepository
            ->findOrderWithBooksByConfirmationNumber($confirmationNumber);

		return new JsonResponse($jsonableOrder->toArray());
    }

    public function store(Request $request)
    {
        $this->validator->validateStoreRequest($request);

        $cart = $this->cartRepository->get($request->cookies->get('PHPSESSID'));

        try {
            $reservation = $cart->reserveItems(
                $request->request->get('email'),
                $this->bookItemRepository
            );

            $charge = $this->paymentGateway->charge(
                $reservation->totalCost(),
                $request->request->get('payment_token'),
                $reservation->getEmail()
            );

            $order = (new Model)
                ->setItems($reservation->getItems())
                ->setEmail($reservation->getEmail())
                ->setAmount($charge->getAmount())
                ->setCardLastFour($charge->getCardLastFour())
                ->generateConfirmationNumber();

            $reservation->complete(
                $order,
                $this->orderRepository,
                $this->bookItemRepository,
                $this->mailer
            );

            return new JsonResponse(['success' => true], 201);
        } catch (PaymentFailedException $e) {
            $reservation->cancel();

            return $this->respondWithException($e);
        } catch (NotEnoughInventoryException $e) {
            return $this->respondWithException($e);
        }
    }

    public function update($orderId, Request $request)
    {
        $this->authenticator->verifyAdminRequest($request);

        $newOrderStatus = $request->request->get('status');

        $this->orderRepository->updateOrderStatus($newOrderStatus);

        if ($newOrderStatus === 'shipped') {
            $order = $this->orderRepository->findById($orderId);

            $this->mailer->send(
                $order->getEmail(),
                new Email\OrderWasShippedEmail($order)
            );
        }

        return JsonResponse(['success' => true]);
    }

    protected function respondWithException($e)
    {
        return JsonResponse([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}
