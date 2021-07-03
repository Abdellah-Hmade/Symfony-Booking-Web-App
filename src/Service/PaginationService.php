<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;

class PaginationService{

private $entityClass;
private $limit= 10;
private $currentPage=1;
private $manager;
private $twig;
private $route;
private $templatePath;

public function __construct(EntityManagerInterface $manager,Environment $twig,RequestStack $request,$templatePath)
{
    $this->route=$request->getCurrentRequest()->attributes->get('_route');
    $this->manager=$manager;

    $this->twig=$twig;
    $this->templatePath=$templatePath;
}

public function getRoute(){
   return $this->route;
   }

public function setRoute($route){
    $this->route=$route;
   return $this;
   }

public function setPage($page){
    $this->currentPage=$page;
   return $this;
   }

public function display(){
    
    $this->twig->display($this->templatePath,[
        'page'=>$this->currentPage,
        'pages'=>$this->getPages(),
        'route'=>$this->route
    ]);
}   

public function getPage(){
   return $this->currentPage;
   }


public function setLimit($limit){
    $this->limit=$limit;
   return $this;
   }

public function getLimit(){
   return $this->limit;
   }

public function setEntityClass($entityClass){
 $this->entityClass=$entityClass;
return $this;
}

public function getEntityClass(){
return $this->entityClass;
}

public function getData(){
$offset=($this->currentPage-1)*$this->limit;
$repo=$this->manager->getRepository($this->entityClass);
$data=$repo->findBy([],[],$this->limit,$offset);
return $data;
}

public function getPages(){ 
    return ceil(count($this->manager->getRepository($this->entityClass)->findAll())/$this->limit);
}
}

?>