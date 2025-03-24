<?php

namespace App\Controller;

use App\Entity\Book;
use App\Message\EntityCreate;
use App\Message\EntityDelete;
use App\Message\EntityStore;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/books', name: 'book_', format: 'json')]
class BookController extends AbstractController
{
    use DispatchAndResponse;


    public function __construct(
        readonly private BookRepository $repository,
        readonly private MessageBusInterface $messageBus
    )
    {
    }

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json($this->repository->findAll());
    }

    #[Route('/{id}', name: 'get', methods: ['GET'])]
    public function get( #[MapQueryParameter(filter: \FILTER_VALIDATE_INT)] int $id): JsonResponse
    {
        return $this->json($this->repository->find($id));
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function create( #[MapRequestPayload] Book $book): JsonResponse
    {
        $message = new EntityCreate($book);
        return $this->dispatchAndResponse($message);
    }

    #[Route('/{id}', name: 'store', methods: ['PATCH'])]
    public function store(#[MapQueryParameter(filter: \FILTER_VALIDATE_INT)] int $id,
                          #[MapRequestPayload] Book $book
    ): JsonResponse
    {
        $message = new EntityStore($book);
        return $this->dispatchAndResponse($message);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(#[MapQueryParameter(filter: \FILTER_VALIDATE_INT)] int $id): JsonResponse
    {
        $book  = $this->repository->find($id);
        $message = new EntityDelete($book);
        return $this->dispatchAndResponse($message);
    }


}
