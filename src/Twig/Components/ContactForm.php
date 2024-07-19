<?php

namespace App\Twig\Components;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class ContactForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp]
    public bool $isSubmit = false;

    public function __construct(private EntityManagerInterface $em, private ContactRepository $cr, private MailerInterface $mi)
    {
        
    }
    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(ContactType::class);
    }

    #[LiveAction]
    public function saveContact()
    {
        $this->submitForm();

        /** @var Contact $contact */
        $contact = $this->getForm()->getData();
        if (!$this->cr->findOneBy(['email' => $contact->getEmail()])) {
            $contact->setCreatedAt(new \DateTimeImmutable);
            $this->em->persist($contact);
            $this->em->flush();
        }
        $email = (new TemplatedEmail())
            ->from('jepeuxpasjaiformation@lucaschamontin.com')
            ->to('chamontin.lucas@gmail.com')
            ->subject('Contact pour le livre blanc')

            // path of the Twig template to render
            ->htmlTemplate('emails/LivreBlanc.html.twig')
            ->context([
                'data' => $contact
            ]);
        
        $this->mi->send($email);
        $this->isSubmit = true;
    }
}
