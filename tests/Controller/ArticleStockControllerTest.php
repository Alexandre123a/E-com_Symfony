<?php

namespace App\Test\Controller;

use App\Entity\ArticleStock;
use App\Repository\ArticleStockRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleStockControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ArticleStockRepository $repository;
    private string $path = '/article/stock/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(ArticleStock::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ArticleStock index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'article_stock[intitule]' => 'Testing',
            'article_stock[prix]' => 'Testing',
            'article_stock[description]' => 'Testing',
            'article_stock[idType]' => 'Testing',
            'article_stock[idMarque]' => 'Testing',
        ]);

        self::assertResponseRedirects('/article/stock/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new ArticleStock();
        $fixture->setIntitule('My Title');
        $fixture->setPrix('My Title');
        $fixture->setDescription('My Title');
        $fixture->setIdType('My Title');
        $fixture->setIdMarque('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ArticleStock');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new ArticleStock();
        $fixture->setIntitule('My Title');
        $fixture->setPrix('My Title');
        $fixture->setDescription('My Title');
        $fixture->setIdType('My Title');
        $fixture->setIdMarque('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'article_stock[intitule]' => 'Something New',
            'article_stock[prix]' => 'Something New',
            'article_stock[description]' => 'Something New',
            'article_stock[idType]' => 'Something New',
            'article_stock[idMarque]' => 'Something New',
        ]);

        self::assertResponseRedirects('/article/stock/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getIntitule());
        self::assertSame('Something New', $fixture[0]->getPrix());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getIdType());
        self::assertSame('Something New', $fixture[0]->getIdMarque());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new ArticleStock();
        $fixture->setIntitule('My Title');
        $fixture->setPrix('My Title');
        $fixture->setDescription('My Title');
        $fixture->setIdType('My Title');
        $fixture->setIdMarque('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/article/stock/');
    }
}
