<?php

namespace App\Controller;

use App\Entity\Car;
use App\Repository\CarRepository;
use App\Form\CarType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClassController extends AbstractController
{
    #[Route('/class', name: 'app_class')]
    public function index(): Response
    {
        return $this->render('class/index.html.twig', [
            'controller_name' => 'ClassController',
        ]);
    }
    #[Route('/liste/{id}', name: 'app_list')]
    public function listeid($id): Response
    {
        return $this->render('class/id.html.twig', array('id'=>$id));
    }


    #[Route('/listcar', name: 'app_list_car')]
    public function listcar(CarRepository $CarRepository): Response
    {
      $cars = $CarRepository->findAll();
        return $this->render('class/listcar.html.twig', array('cars'=>$cars));
    }
    #[Route('/listcarid/{id}', name: 'app_list_car_id')]
    public function listcarId($id , CarRepository $CarRepository ): Response
    {
      $carid[] = $CarRepository->find($id);
    
        return $this->render('class/detailscar.html.twig', array('carsid'=>$carid));
    }


    
    #[Route('/add', name: 'app_add')]
    public function add(Request $req, CarRepository $carRepo): Response
    {
      $car= new Car();
      $formCar = $this->createForm(CarType::class, $car);
      $formCar->handleRequest($req);
      if($formCar->isSubmitted()){
        $carRepo->save($car,true );
        return $this->redirectToRoute('app_list_car');
      }
      

      return $this->renderForm('class/add.html.twig',['x'=>$formCar]);
    }
    #[Route('/supprimer/{id}', name: 'app_supprimer')]
    public function supprimer(CarRepository $carRepo,Car $car ): Response
    {
        $carRepo->remove($car,true);
        return $this->redirectToRoute('app_list_car');
        return $this->render('class/listcar.html.twig',[
      ]);
    }
    #[Route('/update/{id}', name: 'app_update')]
    public function update(Request $req, CarRepository $carRepo,Car $car ): Response
    {
      // {id} marbouta bel objet car 
      $formUpdate = $this->createForm(CarType::class,$car);
      $formUpdate->handleRequest($req);
      
      if($formUpdate->isSubmitted()){
        $carRepo->save($car,true );
        return $this->redirectToRoute('app_list_car');
      }
      

      return $this->renderForm('class/update.html.twig',[
        'formUpdate'=>$formUpdate ,
        'car'=>$car
      ]);
    }


    #[Route('/class1', name: 'app_class1')]
    public function index1(): Response
    {
      $student = "ahmed";
      $formations = array(
        array(
            'ref' => 'form147', 'Titre' => 'Formation Symfony
        4', 'Description' => 'formation pratique',
            'date_debut' => '12/06/2020', 'date_fin' => '19/06/2020',
            'nb_participants' => 19
        ),
        array(
            'ref' => 'form177', 'Titre' => 'Formation SOA',
            'Description' => 'formation theorique', 'date_debut' => '03/12/2020', 'date_fin' => '10/12/2020',
            'nb_participants' => 0
        ),
        array(
            'ref' => 'form178', 'Titre' => 'Formation Angular',
            'Description' => 'formation theorique', 'date_debut' => '10/06/2020', 'date_fin' => '14/06/2020',
            'nb_participants' => 12
        )
    );
        return $this->render('class/list.html.twig', array('st'=> $student , 'fr'=> $formations));
    }
}
