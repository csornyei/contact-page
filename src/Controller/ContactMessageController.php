<?php

namespace App\Controller;

use App\Entity\ContactMessage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactMessageController extends AbstractController
{
    /**
     * @Route("/", name="contact_message")
     */
    public function index(Request $request) {
        $message = new ContactMessage();
        $form = $this->createFormBuilder($message)
            -> add('writer_name', TextType::class, ['label' => 'Neved'])
            -> add('writer_email', TextType::class, ['label' => 'E-mail címed'])
            -> add('message_text', TextareaType::class, ['label' => 'Üzenet szövege'])
            -> add('save', SubmitType::class, ['label' => "Küldés"])
            -> getForm();

        $result = '';
        $resultText = '';

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $message = $form->getData();
                if ($message->isEverythingSet()) {
                    $this->saveMessage($message);
                    $result = 'success';
                    $resultText = "Köszönjük szépen a kérdésedet. Válaszunkkal hamarosan keresünk a megadott e-mail címen.";
                } else {
                    $result = 'error';
                    $resultText = "Hiba! Kérjük töltsd ki az összes mezőt!";
                }

            }
        }

        return $this->render('contact_message/index.html.twig', [
            'form' => $form->createView(),
            'text' => $resultText,
            'result' => $result,
            'active' => 'new'
        ]);
    }
    /**
     * @Route("/messages", name="messages")
     */
    public function showMessages() {
        $messages = $this->getDoctrine()
            -> getRepository(ContactMessage::class)
            -> findAll();

        return $this->render('contact_message/showAll.html.twig', [
            'messages' => $messages,
            'active' => 'messages'
        ]);
    }

    /**
     * @Route("/messages/{id}", name="message")
     */
    public function showOneMessage($id) {
        $message = $this->getDoctrine()
            -> getRepository(ContactMessage::class)
            -> find($id);

        if (!$message) {
            throw $this->createNotFoundException(
                'No message found for id '.$id
            );
        }

        return $this->render('contact_message/showOne.html.twig', [
            'message' => $message,
            'active' => 'messages'
        ]);
    }

    private function saveMessage(ContactMessage $message) {
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($message);
        $entityManager->flush();

        return $message->getId();
    }
}
