<?php

namespace App\DataFixtures;
use Faker\Factory;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Anonce;
use App\Entity\Booking;
use App\Entity\Comment;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder=$encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker=Factory::create('fr_FR');
        $adminUser=new User();
        $adminRole=new Role();
        $adminRole->setTitle("ROLE_ADMIN");
        $manager->persist($adminRole);

        $adminUser->setPrenom("Abdellah")
        ->setNom("Hmade")
        ->setEmail("abdellah.hmade@uit.ac.ma")
        ->setIntroduction("Introduction général")
        ->setDescription('<p>'.join('</p><p>',$faker->paragraphs(5)).'</p>')
        ->setIntroduction($faker->sentence())
        ->setHash($this->encoder->encodePassword($adminUser,'password'))
        ->addUserRole($adminRole)
        ->setAvatar("https://avatarfiles.alphacoders.com/481/48130.jpg");
        $manager->persist($adminUser);

        
        $users=[];
        $genres=['male','female'];
        


        //Gestion des utilisateurs
        for ($i=1; $i<=10 ;$i++ ){
            $user=new User();
            $genre=$faker->randomElement($genres);
            $pictureid=$faker->numberBetween(1,99).'.jpg';
            $picture="https://randomuser.me/api/portraits/";
            if($genre=="male"){$picture=$picture.'men/'.$pictureid;}
            else{$picture=$picture.'women/'.$pictureid;}
            $hash=$this->encoder->encodePassword($user,'password');
            $user->setPrenom($faker->firstname($genre))
            ->setNom($faker->lastname($genre))
            ->setEmail($faker->email)
            ->setIntroduction($faker->sentence())
            ->setDescription('<p>'.join('</p><p>',$faker->paragraphs(5)).'</p>')
            ->setHash($hash)
            ->setAvatar($picture);
            $manager->persist($user);
            $users[]=$user;
        }      # code...
        
        
        //Géstion des Anonces  
        for($i=0;$i<=30;$i++){
        $anonce= new Anonce();
        $titre=$faker->sentence();
        $user=$users[mt_rand(0,count($users)-1)];
        $anonce->setTitre($titre)
                ->setContent('<p>'.join('</p><p>',$faker->paragraphs(5)).'</p>')
                ->setPrix(mt_rand(40,200))
                ->setCoverImage($faker->imageUrl(1000,350))
                ->setIntroduction($faker->paragraph(2))
                ->setAuteur($user)
                ->setChambres(mt_rand(3,6));
        
            //Gestion des images 
        
            for($j=0;$j<=mt_rand(2,5);$j++){
            $image=new Image();
            $image->setUrl($faker->imageUrl())
                  ->setLegend($faker->sentence())

                  ->setAnonce($anonce);
                  $manager->persist($image);
        }
         
        //Gestion des réservations
         
         for($j=0;$j<=mt_rand(0,10);$j++){
            $booking=new Booking();
            $duration=mt_rand(3,10);
            $booker=$users[mt_rand(0,count($users)-1)];
            $startDate=$faker->dateTimeBetween('-3 months');
            $endDate=(clone $startDate)->modify("+$duration days");
            $booking->setCreatedAt($faker->dateTimeBetween('-6 months','-3 months'))
                  ->setStartDate($startDate)
                  ->setEndDate($endDate)
                  ->setAmount($anonce->getPrix()*$duration)
                  ->setAd($anonce)
                  ->setBooker($booker)
                  ->setComment($faker->paragraph());
                
                  $manager->persist($booking); 
                //Gestion des Commentaires 
                  if(mt_rand(0,1)){
                    $comment=new Comment();
                    $comment->setContent($faker->paragraph())
                            ->setRating(mt_rand(1,5))
                            ->setAuteur($booker)
                            ->setAnonce($anonce);
                            $manager->persist($comment);
                  }  
                
                }

        // $product = new Product();
        $manager->persist($anonce);
        }
        $manager->flush();
    }
}
