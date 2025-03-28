<?php

namespace App\Controller;

use App\Entity\Book;
use App\Message\EntityCreate;
use App\Message\EntityDelete;
use App\Message\EntityStore;
use App\Repository\BookRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;

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
        return $this->json(
            $this->repository->findAll(),
            context: [
                'groups' => ['books','booksAndAuthors'],
                AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true,
                AbstractNormalizer::CIRCULAR_REFERENCE_LIMIT => 3
            ]
        );
    }

    #[Route('/{id}', name: 'get', methods: ['GET'])]
    public function get(#[MapEntity] Book $book): JsonResponse
    {
        return $this->json(
            $book,
            context: [
                'groups' => ['books','booksAndAuthors'],
                AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true,
                AbstractNormalizer::CIRCULAR_REFERENCE_LIMIT => 3
            ]
        );
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function create( #[MapRequestPayload] Book $book): JsonResponse
    {
        $message = new EntityCreate($book);
        return $this->dispatchAndResponse($message);
    }

    #[Route('/{id}', name: 'store', methods: ['PUT'])]
    public function store(#[MapEntity] Book $book, #[MapRequestPayload] Book $dto): JsonResponse
    {
        $book->fillFromEntity($dto);
        $message = new EntityStore($book);
        return $this->dispatchAndResponse($message);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(#[MapEntity] Book $book): JsonResponse
    {
        $message = new EntityDelete($book);
        return $this->dispatchAndResponse($message);
    }


}
