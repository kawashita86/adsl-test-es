<?php
/**
 * Created by PhpStorm.
 * User: Francesco
 * Date: 25/01/2016
 * Time: 08:14
 */
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Provider;

class LoadProviderData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $provider = new Provider();
        $provider->setName('Fastweb');
        $provider->setActive(true);
        $provider->setApi('fw');
        $provider->setDescription('');
        $provider->setShortDescription('');
        $provider->setIdProvider(1);
        $provider->setOffersLink('');

        $manager->persist($provider);
        $manager->flush();

        $provider = new Provider();
        $provider->setName('Tim');
        $provider->setActive(true);
        $provider->setApi('tlcm');
        $provider->setDescription('');
        $provider->setShortDescription('');
        $provider->setIdProvider(2);
        $provider->setOffersLink('');

        $manager->persist($provider);
        $manager->flush();

        $provider = new Provider();
        $provider->setName('Vodafone');
        $provider->setActive(true);
        $provider->setApi('vdfn');
        $provider->setDescription('');
        $provider->setShortDescription('');
        $provider->setIdProvider(4);
        $provider->setOffersLink('');

        $manager->persist($provider);
        $manager->flush();

        $provider = new Provider();
        $provider->setName('Tiscali');
        $provider->setActive(true);
        $provider->setApi('tiscali');
        $provider->setDescription('');
        $provider->setShortDescription('');
        $provider->setIdProvider(5);
        $provider->setOffersLink('');

        $manager->persist($provider);
        $manager->flush();

        $provider = new Provider();
        $provider->setName('Infostrada');
        $provider->setActive(true);
        $provider->setApi('infostrada');
        $provider->setDescription('');
        $provider->setShortDescription('');
        $provider->setIdProvider(6);
        $provider->setOffersLink('');

        $manager->persist($provider);
        $manager->flush();

        $provider = new Provider();
        $provider->setName('Eolo');
        $provider->setActive(true);
        $provider->setApi('eolo');
        $provider->setDescription('');
        $provider->setShortDescription('');
        $provider->setIdProvider(7);
        $provider->setOffersLink('');

        $manager->persist($provider);
        $manager->flush();

        $provider = new Provider();
        $provider->setName('Linkem');
        $provider->setActive(true);
        $provider->setApi('fw');
        $provider->setDescription('');
        $provider->setShortDescription('');
        $provider->setIdProvider(9);
        $provider->setOffersLink('');

        $manager->persist($provider);
        $manager->flush();

    }
}