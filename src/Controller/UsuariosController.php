<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Entity\Curso;
use App\Entity\Usuariocurso;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class UsuariosController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/usuarios', name: 'app_usuarios', methods:['GET'])]
    public function get_usuarios(): JsonResponse
    {
        
        $datos = $this->entityManager->getRepository(Usuario::class)->findAll();

        $json = $this->convertToJson($datos);

        return $json;
    }

    #[Route('/usuarios/add', name: 'app_usuarios_add', methods:['POST'])]
    public function insertUsuario(Request $request): JsonResponse
    {
        $datos = json_decode($request->getContent(), true);

        $usuario = new Usuario($datos['nombre'], $datos['password']);

        $this->entityManager->persist($usuario);
        $this->entityManager->flush();
        return new JsonResponse(['data' => 'Alumno Creado'], JsonResponse::HTTP_CREATED);
    }

    #[Route('/usuarios/delete/{id}', name: 'app_usuarios_delete', methods:['DELETE'])]
    public function deleteUsuario($id): JsonResponse
    {
        $usuario = $this->entityManager->getRepository(Usuario::class)->find($id);

        $this->entityManager->remove($usuario);
        $this->entityManager->flush();
        return new JsonResponse(['data' => 'Alumno Eliminado'], JsonResponse::HTTP_ACCEPTED);
    }

    #[Route('/usuarios/update/{id}', name: 'app_usuarios_update', methods:['PUT'])]
    public function updateUsuario($id, Request $request): JsonResponse
    {
        $usuario = $this->entityManager->getRepository(Usuario::class)->find($id);
        $datos = json_decode($request->getContent(), true);

        empty($datos['nombre']) == true ? : $usuario->setNombre($datos['nombre']);
        empty($datos['password']) == true ? : $usuario->setPassword($datos['password']);
        empty($datos['foto']) == true ? : $usuario->setFoto($datos['foto']);
        empty($datos['admin']) == true ? : $usuario->setAdmin($datos['admin']);

        $this->entityManager->flush();

        return new JsonResponse(['res' => 'Alumno Actualizado', 'data' => json_encode($usuario)], JsonResponse::HTTP_ACCEPTED);
    }

    
    #[Route('/usuarios/login', name: 'app_usuarios_login', methods:['POST'])]
    public function login(Request $request): JsonResponse
    {
        $datos = json_decode($request->getContent(), true);
        $usuario = $this->entityManager->getRepository(Usuario::class)->login($datos['nombre'], $datos['password']);

        return $this->convertToJson($usuario);
    }

    #[Route('/usuarios/curso', name: 'app_usuarios_curso', methods:['POST'])]
    public function cursoUsuario(Request $request): JsonResponse
    {
        $datos = json_decode($request->getContent(), true);

        if($datos['admin'] == 0)
        {
            $query = $this->entityManager->getRepository(Usuario::class)->getCursosUsuarioLevel($datos['idUsuario']);
        } else
        {
            $query = $this->entityManager->getRepository(Usuario::class)->getAllUsuariosCursos();
        }
        

        return $this->convertToJson($query);
    }

    #[Route('/usuarios/{id}', name: 'app_usuarios_id', methods:['GET'])]
    public function get_usuario_id($id): JsonResponse
    {
        $datos = $this->entityManager->getRepository(Usuario::class)->find($id);

        $json = $this->convertToJson($datos);

        return $json;
    }

    private function convertToJson($object): JsonResponse
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new DateTimeNormalizer(), new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $normalized = $serializer->normalize($object, null, array(DateTimeNormalizer::FORMAT_KEY=>'Y/m/d'));
        $jsonContent = $serializer->serialize($normalized, 'json');
        return JsonResponse::fromJsonString($jsonContent, 200);

    }
}
