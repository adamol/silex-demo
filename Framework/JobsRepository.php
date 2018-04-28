<?php

namespace Framework;

class JobsRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function queueEmail($message)
    {
        $sql = '
            INSERT INTO jobs
            (status, type, options, created_at)
            VALUES
            (?, ?, ?, null)
        ';

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'pending', 'send_email', json_encode($message, true)
        ]);
    }

    public function scheduleImageResize($imagePaths)
    {
        foreach ($imagePaths as $imagePath) {
            $sql = '
                INSERT INTO jobs
                (status, type, options, created_at)
                VALUES
                (?, ?, ?, null)
            ';

            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                'pending', 'image_resize', json_encode(['image_path' => $imagePath])
            ]);
        }
    }

    public function findPendingJobs()
    {
        $sql = '
            SELECT id, status, type, options
            FROM jobs
            WHERE status=?
        ';

        $stmt = $this->db->prepare($sql);

        $stmt->execute(['pending']);

        $entries = $stmt->fetchAll();

        return array_map(function($entry) {
            return new Job(
                $entry['id'],
                $entry['status'],
                $entry['type'],
                json_decode($entry['options'], true)
            );
        }, $entries);
    }

    public function updateJobStatus(Job $job, $status)
    {
        $sql = '
            UPDATE jobs
            SET status=?
            WHERE id=?
        ';

        $stmt = $this->db->prepare($sql);

        $stmt->execute([$status, $job->getId()]);

    }
}
