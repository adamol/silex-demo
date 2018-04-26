<?php

namespace Framework;

class Mailer
{
    private $mailer;

    private $jobRepository;

    public function __construct(\Swift_Mailer $mailer, JobsRepository $jobRepository)
    {
        $this->mailer = $mailer;
        $this->jobRepository = $jobRepository;
    }

    public function handle(\Framework\Job $job)
    {
        $options = $job->getOptions();

        $message = (new \Swift_Message($options['subject']))
          ->setFrom($options['from'])
          ->setTo($options['to'])
          ->setBody($options['body']);

        $this->mailer->send($message);
    }

    public function send($to, AbstractEmail $email)
    {
        if ($email instanceof Queueable) {
            $this->jobRepository->queueEmail([
                'to' => $to,
                'subject' => $email->getSubject(),
                'from' => $email->getFrom(),
                'body' => $email->getBody()
            ]);
        } else {
            $message = (new Swift_Message($email->getSubject()))
              ->setFrom($email->getFrom())
              ->setTo($to)
              ->setBody($email->getBody());

            $this->mailer->send($message);
        }
    }
}
