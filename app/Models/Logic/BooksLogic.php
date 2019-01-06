<?php
namespace App\Models\Logic;

use App\Models\Entity\Books;
use Swoft\Db\Db;
use Swoft\Db\Query;
use Swoft\Bean\Annotation\Bean;
use Swoft\Bean\Annotation\Inject;
use Swoft\Log\Log;
use Swoft\Core\Config;

/**
 *
 * @Bean()
 * @uses      BooksLogic
 * @version   2018/1/5
 */
class BooksLogic
{
    public function listBooks($limit = 10, $cursor = null)
    {
        $rows = [];
        $new_cursor = null;
        if ($cursor) {
            $result = Books::findAll([['id' ,'>', $cursor]], ['orderby' => ['id' => 'ASC'], 'limit' => $limit + 1])->getResult();
        } else {
            $result = Books::findAll([], ['orderby' => ['id' => 'ASC'],'limit' => $limit + 1])->getResult();
        }
    
        $last_row = null;
        foreach ($result as $row) {
            if (count($rows) == $limit) {
                $new_cursor = $last_row['id'];
                break;
            }
            array_push($rows, $row);
            $last_row = $row;
        }
        return [
            'books' => $rows,
            'cursor' => $new_cursor,
        ];
    }

    public function create($book, $id = null)
    {
        if ($id) {
            $book['id'] = $id;
        }
        $books = new Books();
        $result = $books->fill($book)->save()->getResult();

        return $result->getId();
    }

    public function read($id)
    {
        return Books::findById($id)->getResult();
    }

    public function update($book)
    {
        $books = new Books();
        $books->setId($book['id']);
        $books->setTitle($book['title'] ?? '');
        $books->setAuthor($book['author'] ?? '');
        $books->setPublishedDate($book['published_date'] ?? '');
        $books->setImageUrl($book['image_url'] ?? '');
        $books->setDescription($book['description'] ?? '');
        $books->setCreatedBy($book['created_by'] ?? '');
        $books->setCreatedById($book['created_by_id'] ?? '');

        return $books->update()->getResult();
    }

    public function delete($id)
    {
        $books = new Books();
        $ret = $books->deleteById($id)->getResult();

        return $ret;
    }

    public function getGoogleClient()
    {
        $prop = \Swoft::getProperties();

        $client = new \Google_Client([
            'client_id'     => $prop->get('google.clientId'),
            'client_secret' => $prop->get('google.clientSecret'),
        ]);
        $client->setRedirectUri($prop->get('google.redirectUri'));
        
        return $client;
    }
}
