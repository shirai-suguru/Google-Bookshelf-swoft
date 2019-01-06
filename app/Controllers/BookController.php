<?php
namespace App\Controllers;

use Swoft\App;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Log\Log;
use Swoft\View\Bean\Annotation\View;
use Swoft\Contract\Arrayable;
use Swoft\Http\Server\Exception\BadRequestException;
use Swoft\Http\Message\Server\Response;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Swoft\Bean\Annotation\Bean;
use Swoft\Bean\Annotation\Inject;
use App\Models\Logic\BooksLogic;
use Swoft\Core\Config;
use App\Models\Entity\Books;
use Swoft\Db\Db;

/**
 * Class IndexController
 * @Controller(prefix="/books")
 */
class BookController
{
    /**
     *
     * @Inject()
     * @var BooksLogic
     */
    private $booksLogic;

    /**
     * @RequestMapping("/")
     * @param Response $response
     * @return Response
     */
    public function redirect(Response $response): Response
    {
        return $response->redirect('/books/');
    }

    /**
     * @RequestMapping("/books/")
     * @View(template="books/list", layout="layouts/base.php")
     * @param Request $request
     * @return array
     */
    public function index(Request $request): array
    {
        $token = null;
        $params = $request->getQueryParams();
        if (!empty($params) && !empty($params['page_token'])) {
            $token = intval($params['page_token']);
        }
        $bookList = $this->booksLogic->listBooks(10, $token);
        return [
            'books' => $bookList['books'],
            'next_page_token' => $bookList['cursor'],
        ];
    }

    /**
     * @RequestMapping(route="/books/add", method={RequestMethod::GET})
     * @View(template="books/form", layout="layouts/base.php")
     * @return array
     */
    public function add(): array
    {
        $action = "Add";

        $book = new Books();
        $book->setTitle('');
        $book->setAuthor('');
        $book->setPublishedDate('');
        $book->setImageUrl('');
        $book->setDescription('');
 
        return compact('action', 'book');
    }


    /**
     * @RequestMapping(route="/books/add", method={RequestMethod::POST})
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function create(Request $request, Response $response): Response
    {
        $id = "";
        $files = $request->getUploadedFiles()['image'];
        $book = $request->getParsedBody();
        if (!$files->getError()) {
            $files->moveTo(\alias('@images') . DS . urlencode($files->getClientFilename()));
            $book['image_url'] = '/images/' . $files->getClientFilename();
        }
        if (!empty($user = session()->get('user'))) {
            $book['created_by'] = $user['name'];
            $book['created_by_id'] = $user['id'];
        }
        // Log::trace(var_export($book, true));

        Db::beginTransaction();
        $books   = new Books();
        $id = $books->fill($book)->save()->getResult();
        Db::commit();

        return $response->redirect('/books/' . $id);
    }

    /**
     * @RequestMapping(route="/books/{id}")
     * @View(template="books/view", layout="layouts/base.php")
     * @param int    $id
     * @return array
     */
    public function view(int $id): array
    {
        $book = $this->booksLogic->read($id);

        return compact('book');
    }

    /**
     * @RequestMapping(route="/books/{id}/edit", method={RequestMethod::GET})
     * @View(template="books/form", layout="layouts/base.php")
     * @param int    $id
     * @return array
     */
    public function edit(int $id): array
    {
        $action = "Edit";
        $book = $this->booksLogic->read($id);

        return compact('action', 'book');
    }

    /**
     * @RequestMapping(route="/books/{id}/edit", method={RequestMethod::POST})
     * @param Request $request
     * @param Response $response
     * @param int    $id
     * @return array
     */
    public function update(int $id, Request $request, Response $response): Response
    {
        $book = $request->getParsedBody();
        $book['id'] = $id;

        $files = $request->getUploadedFiles()['image'];
        if (!$files->getError()) {
            $files->moveTo(\alias('@images'). DS . urlencode($files->getClientFilename()));
            $book['image_url'] = '/images/' . $files->getClientFilename();
        }
        if (!empty($user = session()->get('user'))) {
            $book['created_by'] = $user['name'];
            $book['created_by_id'] = $user['id'];
        }

        $this->booksLogic->update($book);

        return $response->redirect('/books/' . $id);
    }

    /**
     * @RequestMapping(route="/books/{id}/delete", method={RequestMethod::POST})
     * @param Response $response
     * @param int    $id
     * @return array
     */
    public function delete(int $id, Response $response): Response
    {
        $book = $this->booksLogic->read($id);
        if (!empty($book)) {
            $this->booksLogic->delete($id);
            unlink(\alias('@public') . DS . urlencode($book->getImageUrl()));
        }
        
        return $response->redirect('/books/');
    }
}
