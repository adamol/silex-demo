<?php

namespace Order;

use Cart\Repository as CartRepository;
use Books\Item\Repository as BooksRepository;
use Framework\Validator as BaseValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Order\Payment\PaymentGateway;
use Framework\Mailer;
use Auth\Authenticator;

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
        BaseValidator $validator,
        PaymentGateway $paymentGateway,
        CartRepository $cartRepository,
        BooksRepository $bookItemRepository,
        Repository $orderRepository,
        Mailer $mailer,
        Authenticator $authenticator
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
        $order = $this->orderRepository
            ->findOrderWithBooksByConfirmationNumber($confirmationNumber);

        return new JsonResponse([
            'card_last_four' => $order->getCardLastFour(),
            'amount' => $order->getAmount(),
            'email' => $order->getEmail(),
            'confirmation_number' => $order->getConfirmationNumber(),
            'items' => array_map(function($item) {
                return [
                    'id' => $item->getId(),
                    'book' => $item->getBook()->toArray(),
                    'code' => $item->getCode(),
                    'reserved_at' => $item->getReservedAt()
                ];
            }, $order->getBookItems()->getValues())
        ]);
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

            $order = (new \Order\Entities\Order)
                ->setItems($reservation->getItems())
                ->setEmail($reservation->getEmail())
                ->setAmount($charge->getAmount())
                ->setCardLastFour($charge->getCardLastFour())
				->setCreatedAt(new \DateTime('now'))
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
