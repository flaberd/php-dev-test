<?php

namespace silverorange\DevTest\Controller;

use silverorange\DevTest\Context;
use silverorange\DevTest\Template;
use FilesystemIterator;

class ImportData extends Controller
{
    public function getContext(): Context
    {
        $context = new Context();
        $context->title = 'Import posts to database';

        $imported = 0;
        $notFulData = 0;
        $alreadyExists = 0;

        $dir = __DIR__ . '/../../data';
        $iterator = new FilesystemIterator($dir);

        foreach ($iterator as $fileinfo) {
            if ($fileinfo->isFile()) {
                $fullPath = $fileinfo->getPathname();
                $contents = file_get_contents($fullPath);

                $data = json_decode($contents, true);

                if (!$this->dataValidation($data)) {
                    $notFulData++;
                    continue;
                }

                if ($this->importData($data)) {
                    $imported++;
                }else {
                    $alreadyExists++;
                }
            }
        }

        $context->content = "Imported: $imported<br /> Not full data: $notFulData<br /> Already exists: $alreadyExists";
        return $context;
    }

    public function getTemplate(): Template\Template
    {
        return new Template\ImportData();
    }

    protected function importData(array $data): bool
    {

        if ($this->checkForExistingPost($data['id'])) {
            return false;
        }

        $sql = 'INSERT INTO posts (id, title, body, created_at, modified_at, author) VALUES (:id, :title, :body, :created_at, :modified_at, :author)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => $data['id'],
            ':title' => $data['title'],
            ':body' => $data['body'],
            ':created_at' => $data['created_at'],
            ':modified_at' => $data['modified_at'],
            ':author' => $data['author'],
        ]);

        return true;
    }

    protected function checkForExistingPost(string $id): bool
    {
        $sqlCheck = 'SELECT COUNT(*) FROM posts WHERE id = :id';
        $stmtCheck = $this->db->prepare($sqlCheck);
        $stmtCheck->execute([':id' => $id]);
        $exists = $stmtCheck->fetchColumn();

        return (bool)$exists;
    }

    protected function dataValidation(array $data): bool
    {
        return isset($data['id'], $data['title'], $data['body'], $data['created_at'], $data['modified_at'], $data['author']) &&
               $data['id'] !== '' &&
               $data['title'] !== '' &&
               $data['body'] !== '' &&
               $data['created_at'] !== '' &&
               $data['modified_at'] !== '' &&
               $data['author'] !== '';
    }
}
