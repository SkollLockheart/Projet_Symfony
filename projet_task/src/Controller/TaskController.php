<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Entity\Util;
use App\Repository\UtilRepository;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
class TaskController extends AbstractController
{
    #[Route('/task/all', name: 'app_task_all')]
    public function showAllTask(TaskRepository $repo, NormalizerInterface $normalizer): Response
    {
        $data = $repo->findAll();
        return $this->json($data,200,['Content-Type'=>'application/json','Access-Control-Allow-Origin'=>'*','Acces-Control-Allow-Methods'=>'GET'],['groups'=>'task']);
    }

    #[Route('/task/id/{value}', name: 'app_task_id')]
    public function showTaskById(TaskRepository $repo, NormalizerInterface $normalizer,$value): Response
    {
        $data = $repo->find($value);
        if($data == null){
            return $this->json(['error'=>'La categorien\'existe pas'],200,
            ['Content-Type'=>'application/json','Access-Control-Allow-Origin'=>'*','Acces-Control-Allow-Methods'=>'GET']);
        }else{
            return $this->json($data,200,['Content-Type'=>'application/json','Access-Control-Allow-Origin'=>'*','Acces-Control-Allow-Methods'=>'GET'],['groups'=>'task']);
        }
    }

    #[Route('/task/utilname/{value}', name: 'app_task_utilname', methods: 'GET')]
    public function showTaskByUtilName(TaskRepository $taskRepo, NormalizerInterface $normalizer, UtilRepository $utilRepo, $value): Response
    {
        //stocker dans une variable l'objet utilisateur (BDD)
        $user = $utilRepo->findOneBy(array('name'=>$value));
        //stocker dans une variable un tableau d'objet task (BDD)
        $tasks = $taskRepo->findBy(['util'=>$user]);
        //test si aucune t??che ?? ??t?? trouv??
        if($tasks == null){
            return $this->json(['error'=>'Aucune t??che n\'a ??t?? trouv??'],200,
            ['Content-Type'=>'application/json','Access-Control-Allow-Origin'=>'*','Acces-Control-Allow-Methods'=>'GET']);
        //test si l'utilisateur n'existe pas
        }else if($user == null){
            return $this->json(['error'=>'L\'utilisateur '.$value.' n\'existe pas'],200,
            ['Content-Type'=>'application/json','Access-Control-Allow-Origin'=>'*','Acces-Control-Allow-Methods'=>'GET']);
        //sinon retourne le json de toutes les t??che qui correspondent ( qui sont ratach??)
        }else{
            return $this->json($tasks,200,['Content-Type'=>'application/json','Access-Control-Allow-Origin'=>'*','Acces-Control-Allow-Methods'=>'GET'],['groups'=>'task']);
        }
    }

//fonction qui retourne en json une tache par son nom
#[Route('/task/catname/{value}', name: 'app_task_catname', methods: 'GET')]
public function showTaskByCatName(TaskRepository $taskRepo, CategoryRepository $catRepo,
NormalizerInterface $normalizer, $value): Response
{   
    //stocker dans une variable objet category
    $cat = $catRepo->findOneBy(['name'=>$value]);
    //stocker dans une variable un tableau d'objet task (BDD)
    $tasks = $taskRepo->findByNameCat($value);
    //test si la cat??gorie n'existe pas
    if($cat == null){
        return $this->json(['error'=>'La cat??gorie '.$value.' n\'existe pas'],200,
        ['Content-Type'=>'application/json','Access-Control-Allow-Origin'=> '*',
        'Access-Control-Allow-Methods'=>'GET']);
    }
    //test si aucune tache ?? ??t?? trouv??
    else if($tasks == null){
        return $this->json(['error'=>'Aucune tache n\'a ??t?? trouv??'],200,
        ['Content-Type'=>'application/json','Access-Control-Allow-Origin'=> '*',
        'Access-Control-Allow-Methods'=>'GET']);
    }
    //sinon reourne le json de toutes les taches qui correspondent (qui sont ratach??es ?? l'utilisateur)
    else{
        return $this->json($tasks,200,
        ['Content-Type'=>'application/json','Access-Control-Allow-Origin'=> '*',
        'Access-Control-Allow-Methods'=>'GET'],
        ['groups'=>'tasks']);
        //(tableau de donn??e, code retour, ent??te http, groupe pour filtrer)
    }
}
}
