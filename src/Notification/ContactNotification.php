<?php

namespace App\Notification;

use App\Entity\Contact;
use Symfony\Component\Mailer\MailerInterface;
use Twig\Environment;



class ContactNotification
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer )
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function notify(Contact $contact)
    {
        $message = (new \Swift_Message('Message du formulaire de contact de la part de ', $contact->getPrenom()))
            ->setFrom('noreply@meteospit.fr')
            ->setTo('contact@meteospit.fr')
            ->setReplyTo($contact->getEmail())
            ->setBody($this->renderer->render('email/contact.html.twig',[
                'contact' => $contact
            ]), 'text/html');
        $this->mailer->send($message);
    }
}