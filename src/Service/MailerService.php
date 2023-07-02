<?php
namespace App\Service;

use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

/*Service pour generer un e-mail*/
class MailerService{
    public function __construct(private readonly MailerInterface $mailer){}

    public function send(string $to,string $subject, string $templateTwig, array $context){
        $email = (new TemplatedEmail())
            ->from(new Address('noreply@monsite.fr', 'Ecommerce')) //depuis le site
            ->to($to) //vers le user
            ->subject($subject) // Objet du mail
            ->htmlTemplate("mails/$templateTwig") // Template pour le contenu html
            ->context($context); // Donnée contextuelles

        try {
            $this->mailer->send($email);
        }catch(TransportExceptionInterface $transportException){
            throw $transportException;
        }
    }
}