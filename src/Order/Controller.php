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
        $validator,
        $paymentGateway,
        $cartRepository,
        $bookItemRepository,
        $orderRepository,
        Auth\Authenticator $authenticator,
        $mailer
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

        $cart = $this->cartRepository->get($request->getSession());

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
                ->setAmount($charge->amount())
                ->setCardLastFour($charge->getCardLastFour())
                ->generateConfirmationNumber();

            $this->orderRepository->save($order);

            $this->mailer->send(
                $order->getEmail(),
                new Email\OrderConfirmationEmail($order)
            );

            return JsonResponse(['success' => true], 201);
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
