<?php

namespace Portal\PortalBundle\Controller;

use Portal\PortalBundle\Entity\Channel;
use Portal\PortalBundle\Form\ChannelForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ChannelController extends Controller implements BackController
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $channelRepository = $em->getRepository('PortalBundle:Channel');
        $channels = $channelRepository->findAll();
        $user = $this->getUser();
        $data = array('channels' => $channels, 'user' => $user);
        return $this->render('PortalBundle:Channel:index.html.twig', $data);
    }

    public function myChannelsAction()
    {
        $user = $this->getUser();
        $channels = $user->getChannels();

        return $this->render('PortalBundle:Channel:channels.html.twig', array('channels' => $channels));
    }

    public function formCreateAction(Request $request)
    {
        $channel = new Channel();

        $form = $this->createForm(new ChannelForm(), $channel);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $channel->setUser($this->getUser());

            $em->persist($channel);
            $em->flush();

            $session = $request->getSession();
            $session->getFlashBag()->add('message', 'Новый канал сохранен!');

            return $this->redirect($this->generateUrl('portal_my_channels_page'));
        }

        return $this->render('PortalBundle:Channel:create.html.twig', array('form' => $form->createView()));

    }

    public  function  formEditAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $channelRepository = $em->getRepository('PortalBundle:Channel');
        $channel = $channelRepository->find((int)$id);

        if (!$channel) {
            throw $this->createNotFoundException('Не удалось найти такой канал.');
        }

        $form = $this->createForm(new ChannelForm(), $channel);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($channel);
            $em->flush();

            return $this->redirect($this->generateUrl('portal_my_channels_page'));
        }

        return $this->render('PortalBundle:Channel:edit.html.twig',  array('category' => $channel, 'form' => $form->createView()));

    }

    public  function  deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $channelRepository = $em->getRepository('PortalBundle:Channel');
        $channel = $channelRepository->find((int)$id);
        if ($channel) {
            $em->remove($channel);
            $em->flush();
        } else {
            throw $this->createNotFoundException('Не удалось удалить, данный канал не найден.');
        }

        return $this->redirect($this->generateUrl('portal_my_channels_page'));
    }

    function myFollowedAction () {
        $user = $this->getUser();
        $channels = $user->getChannels();
        $subscribers = array();
        foreach ($channels as $channel) {
            foreach ($channel->getFollower() as $follower) {
                $subscribers[$follower->getId()] = $follower;
            }
        }
        return $this->render('PortalBundle:Channel:followed.html.twig', array('subscribers' => $subscribers));
    }

    function followAction ($id) {
        $em = $this->getDoctrine()->getManager();
        $channelRepository = $em->getRepository('PortalBundle:Channel');
        $channel = $channelRepository->find((int)$id);
        if ($channel) {
            $user = $this->getUser();
            $user->addFollowedChannel($channel);
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('portal_channels_page'));
        }
    }

    function unFollowAction ($id) {
        $em = $this->getDoctrine()->getManager();
        $channelRepository = $em->getRepository('PortalBundle:Channel');
        $channel = $channelRepository->find((int)$id);
        if ($channel) {
            $user = $this->getUser();
            $user->removeFollowedChannel($channel);
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('portal_channels_page'));
        }
    }

}
