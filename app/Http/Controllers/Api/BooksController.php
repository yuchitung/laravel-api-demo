<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\BookCreateRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Repositories\BookRepository;
use \Throwable;

/**
 * Class BooksController.
 *
 * @package namespace App\Http\Controllers\Api;
 */
class BooksController extends Controller
{
    /**
     * @var BookRepository
     */
    protected $repository;

    /**
     * BooksController constructor.
     *
     * @param BookRepository $repository
     * @param BookValidator $validator
     */
    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BookCreateRequest $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @throws \Throwable
     */
    public function store(BookCreateRequest $request)
    {
        try {
            $book = $this->repository->create(
                [
                    'name' => $request->input('name'),
                    'author' => $request->input('author'),
                    'price' => $request->input('price'),
                ]
            );

            return response()->json([
                'message' => 'Book created.',
                'data' => $book
            ]);
        } catch (ValidatorException $e) {
            return response()->json([
                'error'   => true,
                'message' => $e->getMessageBag()
            ], 500);
        } catch (Throwable $e) {
            return response()->json([
                'error'   => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($id)
    {
        $book = $this->repository->find($id);

        return response()->json([
            'message' => 'Get a book.',
            'data' => $book,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BookUpdateRequest $request
     * @param  integer  $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @throws  \Throwable
     */
    public function update(BookUpdateRequest $request, $id)
    {
        try {
            $book = $this->repository->update(
                [
                    'name' => $request->input('name'),
                    'author' => $request->input('author'),
                    'price' => $request->input('price'),
                ],
                $id
            );

            return response()->json([
                'message' => 'Book updated.',
                'data' => $book
            ]);
        } catch (ValidatorException $e) {
            return response()->json([
                'error'   => true,
                'message' => $e->getMessageBag()
            ], 500);
        } catch (Throwable $e) {
            return response()->json([
                'error'   => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     */
    public function destroy($id)
    {
        try {
            $deleted = $this->repository->delete($id);

            return response()->json([
                'message' => 'Book deleted.',
                'data' => $deleted
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'error'   => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
