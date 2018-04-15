<?php

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
                'pending', 'image_resize', json_encode(['image_path' => $imagePath)
            ]);
        }
    }

    public function findPendingJobs()
    {
        $sql = '
            SELECT status, type, options
            FROM jobs
            WHERE status=?
        ';

        $stmt = $this->db->prepare($sql);

        $stmt->execute(['pending']);

        $entry = $stmt->fetchAll();

        return new Job(
            $entry['status'],
            $entry['type'],
            json_decode($entry['options'], true)
        );
    }
}
