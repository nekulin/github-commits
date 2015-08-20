<?php
namespace app\commands;

use app\models\Commits;
use app\models\CommitsFiles;
use Guzzle\Http\Client as HttpClient;
use yii\console\Controller;


class ParseController extends Controller
{
    public function actionCommits()
    {
        $http_client = new \Guzzle\Http\Client();
        $client = new \Github\Client();
        try {
            $commits = $client->api('repo')->commits()->all('KnpLabs', 'php-github-api', array('sha' => 'master'));
            foreach ($commits as $commit_info) {
                $commit_info = json_decode($http_client->get($commit_info['url'])->send()->getBody(), true);

                $commit = Commits::findOne([
                    'sha' => $commit_info['sha'],
                ]);
                if (!$commit) {
                    $commit = new Commits();
                    $commit->sha = $commit_info['sha'];
                    $commit->user_name = $commit_info['commit']['committer']['name'];
                    $commit->date_commit = date('Y-m-d', strtotime($commit_info['commit']['committer']['date']));
                    $commit->message = $commit_info['commit']['message'];
                    $commit->save();
                }
                echo $commit->id . PHP_EOL;
                foreach ($commit_info['files'] as $file_info) {
                    $commit_file = CommitsFiles::findOne([
                        'sha' => $file_info['sha'],
                    ]);
                    if (!$commit_file) {
                        $commit_file = new CommitsFiles();
                        $commit_file->sha = $file_info['sha'];
                        $commit_file->commit_id = $commit->id;
                        $commit_file->filename = $file_info['filename'];
                        $commit_file->status = $file_info['status'];
                        $commit_file->additions = $file_info['additions'];
                        $commit_file->deletions = $file_info['deletions'];
                        $commit_file->changes = $file_info['changes'];
                        $commit_file->blob_url = $file_info['blob_url'];
                        $commit_file->date_add = $commit->date_commit;
                        if (!$commit_file->save()) {
                            print_r($commit_file->getErrors());
                            die();
                        }
                    }
                    echo '--' . $commit_file->id . PHP_EOL;
                }
            }
        } catch (\Exception $e) {}
    }
}
