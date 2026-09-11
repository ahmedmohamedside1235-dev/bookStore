<?php

require_once __DIR__ . "/../Model.php";
require_once __DIR__ . "/../../../core/Database.php";

class BookModel extends Model
{
    public static function getDataOfBooks(array $wheres = [], string $sort = "DESC", int $page = 1)
    {
        $DB = Database::getConnection();
        $offset = ($page * 10) - 10;
        $queryWheres = Model::prepareWhereQuery($wheres);
        $data = $DB->query("SELECT 
                                books.*,
                                authors.name AS author_name
                                FROM books
                                LEFT JOIN authors ON authors.id = books.author_id
                                {$queryWheres}
                                ORDER BY id $sort
                                LIMIT 10 OFFSET $offset
                            ");

        $count = $DB->query("SELECT COUNT(*) AS total  
                                FROM books
                                LEFT JOIN authors ON authors.id = books.author_id 
                                {$queryWheres}");
        return [
            "data" => $data->fetchAll(),
            "count" => ceil(($count->fetch()['total'] / 10)),
            "currentPage" => $page
        ];
    }

    public static function addBook(): array
    {
        $DB = Database::getConnection();
        $request = $DB->prepare("INSERT INTO books
        (author_id,title,image,description,price,stock)
        VALUES
            (:author_id,:title,:image,:description,:price,:stock)
        ");
        $request->execute([
            "author_id" => Request::input('authorId'),
            "title" => Request::input('title'),
            "image" => self::uploadeImage('image'),
            "description" => Request::input('description'),
            "price" => Request::input('price'),
            "stock" => Request::input('stock')
        ]);

        $bookId = $DB->lastInsertId(true);
        $book = $DB->query("SELECT * FROM books WHERE id = {$bookId}")->fetch();
        return $book;
    }

    private static function uploadeImage(string $fileName): ?string
    {
        if (Request::hasFile($fileName)) {
            $file = Request::file($fileName);
            $tmpPath = $file['tmp_name'];
            if (self::checkValidFileImage($tmpPath)) {
                $name = $file['name'];
                $fileOriginalName = pathinfo($name, PATHINFO_FILENAME);
                $fileOriginalExtension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                $allowedExtension = ['png', 'jpg', 'webp', 'jpeg'];

                if (!in_array($fileOriginalExtension, $allowedExtension)) {
                    Response::json(['image' => ['The Extension is not allowed']], status: 403);
                }

                $newFileName = $fileOriginalName . "_" . time() . "." . $fileOriginalExtension;
                $uploadDir = __DIR__ . "/../../../public/assets/images/uploads";

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $uploadePath = $uploadDir . "/" . $newFileName;

                if (!move_uploaded_file($tmpPath, $uploadePath)) {
                    Response::json(['image' => ['Faild To Upload Image please try again']], status: 403);
                }

                return $newFileName;
            }
        }
        return null;
    }

    private static function checkValidFileImage(string $fileTmpName)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $fileTmpName);
        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
        if (!in_array($mime, $allowedMimes)) {
            Response::json(['image' => ["Invalid file content. The file does not match an allowed image type."]], status: 403);
        }

        return true;
    }
}
