<?php

namespace App\Controller;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use App\Services\MarkdownHelper;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sentry\State\HubInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Symfony\Contracts\Cache\CacheInterface;

class QuestionController extends AbstractController
{
    private $logger;
    private $isDebug;
    private $questionRepository;
    public function __construct(LoggerInterface $logger, bool $isDebug, QuestionRepository $questionRepository)
    {
        $this->logger=$logger;
        $this->isDebug = $isDebug;
        $this->questionRepository = $questionRepository;
    }

    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(Environment $environment)
    {
        /*
        // fun example of using the Twig service directly!
        $html = $environment->render('question/homepage.html.twig');

        return new Response($html);
        */
       // $html = $environment->render('question/homepage.html.twig');

      //  return new Response($html);
      //  $repository = $this->questionRepository->getRepository(Question::class);
       // dd($repository);
      //  $questions = $repository->findBy([], ['askedAt' => 'DESC']);
        $questions = $this->questionRepository->findAllAskedOrderedByNewest();

      //  dd($questions);
        return $this->render('question/homepage.html.twig', ['questions'=>$questions]);
    }

    /**
     * @Route("/questions/new")
     */
    public function new(EntityManagerInterface $entityManager)
    {
        return new Response('Sounds like a GREAT feature for V2!');
       /* $question = new Question();
        $question->setName("Ibrahim ELsanosi")
            ->setSlug('Missing-pants-'.rand(0,1000))
            ->setQuestion(<<<EOF
Hi! So... I'm having a *weird* day. Yesterday, I cast a spell
to make my dishes wash themselves. But while I was casting it,
I slipped a little and I think `I also hit my pants with the spell`.
When I woke up this morning, I caught a quick glimpse of my pants
opening the front door and walking out! I've been out all afternoon
(with no pants mind you) searching for them.
Does anyone have a spell to call your pants back?
EOF
                    );
        $question->setVotes(rand(-20, 50));

        if(rand(0, 10) > 2){
            $question->setAskedAt(new \DateTime(sprintf('-%d days', rand(1,100))));
        }
      //  dd($question);
        $entityManager->persist($question);
        $entityManager->flush();
        return new Response(sprintf(
            'Well hallo! The shiny new question is id #%d, slug: %s, votes: #%d',
            $question->getId(),
            $question->getSlug(),
            $question->getVotes()
        ));*/

    }
    /**
     * @Route("/questions/{slug}", name="app_question_show")
     */
    public function show(Question $question)
    {
        if ($this->isDebug) {
            $this->logger->info('We are in debug mode!');
        }
        $answers = [
            'Make sure your cat is sitting `purrrfectly` still 🤣',
            'Honestly, I like furry shoes better than MY cat',
            'Maybe... try saying the spell backwards?',
        ];
        return $this->render('question/show.html.twig', [
            'question' => $question,
            'answers' => $answers,
        ]);
    }

    /**
     * @Route("/questions/{slug}/vote", name="app_question_vote", methods="POST")
     */
    public function questionVote(Question $question, Request $request, EntityManagerInterface $entityManager)
    {
        $direction = $request->request->get('direction');
        if($direction=="up") {
            $question->upVote();
        }elseif($direction=='down'){
            $question->downVote();
        }
        $answers = [
            'Make sure your cat is sitting `purrrfectly` still 🤣',
            'Honestly, I like furry shoes better than MY cat',
            'Maybe... try saying the spell backwards?',
        ];
      //  $entityManager->persist($question);
        $entityManager->flush();
        return $this->redirectToRoute('app_question_show', ['slug'=>$question->getSlug()
        ]);

     //   dd($request->attributes->all());
    }
        /*public function show($slug, MarkdownHelper $markdownHelper, HubInterface $sentryHub)
        {
        dump($this->isDebug);
        dump($sentryHub);
        $this->logger->info("Log in Controller");
       // dump($isDubug . ' Controller');
       // dump($this->getParameter('cache_adapter'));
        $answers = [
            'Make sure your cat is sitting `purrrfectly` still 🤣',
            'Honestly, I like furry shoes better than MY cat',
            'Maybe... try saying the spell backwards?',
        ];
        $questionText = "I've been turned into a cat, any *thoughts* on how to turn back? While I'm **adorable**, I don't really care for cat food.";
        $parsedQuestionText = $markdownHelper->parse($questionText);

           // $parsedQuestionText = $markdownParser->transformMarkdown($questionText);
       // $cache->get("fegfefg");
        //$parsedQuestionText = $cache->get('markdown_'.md5($questionText), function() use ($questionText, $markdownParser) {
          //  return $markdownParser->transformMarkdown($questionText);
       // });
        //dump($cache);
           // throw new \Exception('bad stuff happened!');
           // $repository =  $this->entityManager->getRepository(Question::class);
           /** @var  Question|null $question */
           // $question = $this->questionRepository->findOneBy(['slug'=>$slug]);
           // $question = $repository->findAll();
           // if(!$question){
             //   throw $this->createNotFoundException(sprintf('no question found for slug "%s"', $slug));
          //  }

         //   dd($question);
       /* return $this->render('question/show.html.twig', [
           // 'question' => ucwords(str_replace('-', ' ', $slug)),
            'question' => $question,
          //  'questionText' => $parsedQuestionText,
            'answers' => $answers,
        ]);

            return $this->render('question/show.html.twig', [
                'question' => $question,
                'answers' => $answers
            ]);
    }*/


}
