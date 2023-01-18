<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends AbstractController
{
    #[Route('/category/all', name: 'app_category_all', methods: 'GET')]
    public function showAllCategory(CategoryRepository $repo, NormalizerInterface $normalizer): Response
    {
        $data = $repo->findAll();
        return $this->json($data,200,['Content-Type'=>'application/json','Access-Control-Allow-Origin'=>'*','Acces-Control-Allow-Methods'=>'GET'],['groups'=>'categorie']);
    }

    #[Route('/category/id/{value}', name: 'app_category_id', methods: 'GET')]
    public function showCategoryById(CategoryRepository $repo, NormalizerInterface $normalizer, $value): Response
    {
        $data = $repo->find($value);
        if($data == null){
            return $this->json(['error'=>'La categorien\'existe pas'],200,
            ['Content-Type'=>'application/json','Access-Control-Allow-Origin'=>'*','Acces-Control-Allow-Methods'=>'GET']);
        }else{
            return $this->json($data,200,
            ['Content-Type'=>'application/json','Access-Control-Allow-Origin'=>'*','Acces-Control-Allow-Methods'=>'GET'],
            ['groups'=>'categorie']);
        }
    }

    #[Route('/category/name/{value}', name: 'app_category_name', methods: 'GET')]
    public function showCategoryByName(CategoryRepository $repo, NormalizerInterface $normalizer, $value): Response
    {
        $data = $repo->findOneBy(array('name'=>$value));
        if($data == null){
            return $this->json(['error'=>'La categorien\'existe pas'],200,
            ['Content-Type'=>'application/json','Access-Control-Allow-Origin'=>'*','Acces-Control-Allow-Methods'=>'GET']);
        }else{
            return $this->json($data,200,
            ['Content-Type'=>'application/json','Access-Control-Allow-Origin'=>'*','Acces-Control-Allow-Methods'=>'GET'],
            ['groups'=>'categorie']);
        }
    }

    #[Route('/category/add', name: 'app_category_add', methods: 'POST')]
    public function addCategory(CategoryRepository $repo,EntityManagerInterface $manager, Request $request, SerializerInterface $serializer): Response
    {
        //récupération du json
        $json = $request->getContent();
        //instancier un nouvel objet catégorie
        $cat = new Category();
        //transforme le json en objet
        $recup = $serializer->deserialize($json, Category::class, 'json');
        //setter la valeur de name (de récup) dans l'attribut name de l'objet cat
        $cat->setName($recup->getName());
        //stocker dans manager le nouvel objet category
        $manager->persist($cat);
        //insertion en BDD
        $manager->flush();
        //afficher l'objet
        dd($recup);
    }

    #[Route('/category/update/{id}', name: 'app_category_update', methods: 'PATCH')]
    public function updateCategory(EntityManagerInterface $manager,
    Request $request, CategoryRepository $repo, $id, SerializerInterface $serializer
    ): Response
    {
        $cat = $repo->find($id);
        if($cat == null){      
            return $this->json(['error'=>'La catégorie n\'existe pas'],200,
            ['Content-Type'=>'application/json','Access-Control-Allow-Origin'=> '*',
            'Access-Control-Allow-Methods'=>'PATCH']);
        }
        else{
            $json = $request->getContent();
            $recup = $serializer->decode($json , 'json');
            if($cat->getName()== $recup['name']){
                return $this->json(['error'=>'Aucune modification à apporter'],200,
                ['Content-Type'=>'application/json','Access-Control-Allow-Origin'=> '*',
                'Access-Control-Allow-Methods'=>'PATCH']);
            }
            else{
                $cat->setName($recup['name']);
                $manager->persist($cat);
                $manager->flush();
                return $this->json(['info'=>'La catégorie '.$cat->getName().' a été modifié'],200,
                ['Content-Type'=>'application/json','Access-Control-Allow-Origin'=> '*',
                'Access-Control-Allow-Methods'=>'PATCH']);
            }
        }
    }

        #[Route('/category/delete/{id}', name: 'app_category_delete', methods: 'DELETE')]
        public function deleteCategory(EntityManagerInterface $manager,
        Request $request, CategoryRepository $repo, TaskRepository $taskRepo, $id
        ): Response
        {
            $cat = $repo->find($id);
            $tasks = $taskRepo->findByIdCat(['categories'=>$cat]);
            if($cat == null){
                return $this->json(['error'=>'La catégorie n\'existe pas'],200,
                ['Content-Type'=>'application/json','Access-Control-Allow-Origin'=> '*',
                'Access-Control-Allow-Methods'=>'DELETE']);
            }
            else if(findBy($tasks) != null){
                return $this->json(['error'=>'La catégorie est lié à des taches'],200,
                ['Content-Type'=>'application/json','Access-Control-Allow-Origin'=> '*',
                'Access-Control-Allow-Methods'=>'GET']);
            }
            else{
                $manager->remove($cat);
                $manager->flush();
                return $this->json(['info'=>'La catégorie '.$id.' à bien été supprimé'],200,
                ['Content-Type'=>'application/json','Access-Control-Allow-Origin'=> '*',
                'Access-Control-Allow-Methods'=>'DELETE']);
            }
        }
}
