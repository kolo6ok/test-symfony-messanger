<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Message\EntityCreate;
use App\Message\EntityDelete;
use App\Message\EntityStore;
use App\Repository\AuthorRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;

#[Route('/authors', name: 'author_', format: 'json')]
class AuthorController extends AbstractController
{
    use DispatchAndResponse;


    public function __construct(
        readonly private AuthorRepository $repository,
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
                'groups' => ['authors'],
                AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true,
                AbstractNormalizer::CIRCULAR_REFERENCE_LIMIT => 3
            ]
        );
    }

    #[Route('/{id}', name: 'get', methods: ['GET'])]
    public function get(#[MapEntity] Author $author): JsonResponse
    {
        return $this->json(
            $author,
            context: [
            'groups' => ['authors'],
            AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true,
            AbstractNormalizer::CIRCULAR_REFERENCE_LIMIT => 3
        ]);
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function create( #[MapRequestPayload] Author $author): JsonResponse
    {
        $message = new EntityCreate($author);
        return $this->dispatchAndResponse($message);
    }

    #[Route('/{id}', name: 'store', methods: ['PUT'])]
    public function store(#[MapEntity] Author $author, #[MapRequestPayload] Author $dto): JsonResponse
    {
        $author->fillFromEntity($dto);
        $message = new EntityStore($author);
        return $this->dispatchAndResponse($message);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(#[MapEntity] Author $author): JsonResponse
    {
        $message = new EntityDelete($author);
        return $this->dispatchAndResponse($message);
    }


}
