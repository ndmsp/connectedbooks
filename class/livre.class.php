<?php
/*

   Copyright (c) 2012/2013, Thomas Diot
   
   Permission is hereby granted, free of charge, to any person
   obtaining a copy of this software and associated documentation
   files (the "Software"), to deal in the Software without
   restriction, including without limitation the rights to use,
   copy, modify, merge, publish, distribute, sublicense, and/or sell
   copies of the Software, and to permit persons to whom the
   Software is furnished to do so, subject to the following
   conditions:
   
   The above copyright notice and this permission notice shall be
   included in all copies or substantial portions of the Software.
   
   THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
   EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
   OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
   NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
   HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
   WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
   FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
   OTHER DEALINGS IN THE SOFTWARE.

*/

class Livre{

    private $_id;
    private $_title;
    private $_author;
    private $_genre;
    private $_year;
    private $_resume;
    private $_cover;
    private $_note;
    private $_collection;
    private $_isbn;
	private $_date;

    private $_db; // Instance de PDO
	
	private static $_erreur = 'img/erreur.gif';

    // Pattern books-by-isbn.com
    private static $_bookIsbn = 'http://www.books-by-isbn.com/';
    private static $_bookGoogle = 'https://www.googleapis.com/books/v1/volumes?q=:isbn=';

    // Pattern Amazon
    private static $_amazonPattern = '/<p class="alink"><a href="(.*)">details/';
    private static $_amazonPattern1 = '#<p class="alink"><a href="(.*)">details  (<strong>France</strong>).</a></p>#';

    // Pattern title
    private static $_titlePattern = '/<h1 class=\"title\">(.*)<\/h1>/';
    private static $_titlePattern1 = '#<g:plusone href="(.*)" count="false"></g:plusone>#';

    // Pattern author
    private static $_authorPattern = '/<span class=\"auts\">(.*)<\/span>/';
    private static $_authorPattern1 = '<a href="(.*)">';
    private static $_author1Pattern = '/<>(.*)<\/a>/';
    private static $_author1Pattern1 = '</a>';

    // Pattern Collection
    private static $_collectionPattern = '/<p class=\"pubinf\">(.*)<\/a>/';
    private static $_collectionPattern1 = '#<a href="(.*)">#';

    // Pattern year
    private static $_yearPattern = '/·(.*)<\/p>/';
    private static $_yearPattern1 = '# #';

    // Pattern Cover
    private static $_coverPattern = '/<img class=\"cover\" src=\"(.*)"\ \/>/';
    private static $_coverPattern1 = '#" width="(.*)" height="(.*)" alt="(.*)#';

    // Pattern Resume
    private static $_resumePattern = '/"description": "(.*)",/';
    private static $_resumePattern1 = '#"description": "(.*)",#';

    // Pattern Note
    private static $_notePattern = '/<div id="averageCustomerReviewRating" class="gry txtnormal">(.*) étoiles sur 5<\/div>/';
    private static $_notePattern1 = '#<div id="averageCustomerReviewRating" class="gry txtnormal">(.*) étoiles sur 5<\/div>#';


    public function __construct($db)
    {
        $this->setDb($db);
    }


    public function hydrate(array $donnees){
        foreach ($donnees as $key => $value){
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method)){
                $this->$method($value);
            }
        }
    }

    // GETTERS
    public function getId(){
        return $this->_id;
    }
    public function getTitle(){
        return $this->_title;
    }
    public function getAuthor(){
        return $this->_author;
    }
    public function getGenre(){
        return $this->_genre;
    }
    public function getYear(){
        return $this->_year;
    }
    public function getResume(){
        return $this->_resume;
    }
    public function getCover(){
		return (!@getimagesize($this->_cover)) ? (self::$_erreur) : ($this->_cover);
        return $this->_cover;
    }
    public function getNote(){
        return $this->_note;
    }
    public function getCollection(){
        return $this->_collection;
    }
    public function getIsbn(){
        return $this->_isbn;
    }
	public function getDate(){
		return $this->_date;
	}


    // SETTERS
    public function setId($id){
        $this->_id = $id;
    }
    
	public function setTitle($title){
        if(is_string($title) && strlen($title) >= 2){
            $this->_title = $title;
        }
    }
  
	public function setAuthor($author){
        if(is_string($author) && strlen($author) >= 2){
            $this->_author = $author;
        }
    }

    public function setYear($year){
        $this->_year = $year;
    }

    public function setGenre($genre){
        $this->_genre = $genre;
    }

    public function setResume($resume){
        if(is_string($resume) && strlen($resume) >= 2){
            $this->_resume = $resume;
        }
    }

    public function setCover($cover){
        if(preg_match('#http://#', $cover)){
            $this->_cover = $cover;
        }
    }

    public function setCollection($collection){
        if(is_string($collection)){
            $this->_collection = $collection;
        }
    }

    public function setIsbn($isbn){
        if(is_numeric($isbn) && (strlen($isbn) == 10 OR strlen($isbn) == 13)){
            $this->_isbn = $isbn;
        }
    }

    public function setNote($note){
        $this->_note = $note;
    }
	
	public function setDate($date){
		$this->_date = $date;
	}
	
	public function ParsData($pattern, $document, $pattern1, $number){
        // Pars function to extract data from the source code of the page
        preg_match_all($pattern, $document, $matches);
        foreach($matches as $val){
            $donnees = $val[$number];
            if($pattern1 != '##'){
                $donnees = preg_replace($pattern1,'',$donnees);
            }
        }
        return $donnees;
    }

    public function accent($str){
        // Encoding problems could be resolved with this function (UTF_8/ISO)
		$str = htmlentities($str, ENT_COMPAT, 'UTF-8');
        return $str;
    }

    public function scanIsbn($isbn){

        // Convert the isbn number
        if(!is_array($isbn)){
            $isbn = preg_replace('#-#', '', $isbn);
            $this->_isbn = $isbn;
        }

        // Get the source code from the external website
        $fichierIsbn = file_get_contents(self::$_bookIsbn.$isbn);
        $fichierGoogle = file_get_contents(self::$_bookGoogle.$isbn);
        $fichierAmazon = file_get_contents($this->ParsData(self::$_amazonPattern, $fichierIsbn, self::$_amazonPattern1, 0));

        // Extract important data from the source
        $livre = array(
            'id' => '',
			// ParsData(search, file, extract, 0);
            'title' =>  $this->accent($this->ParsData(self::$_titlePattern, $fichierIsbn, self::$_titlePattern1, 0)),
            'author' => $this->accent($this->ParsData(self::$_author1Pattern, $this->ParsData(self::$_authorPattern, $fichierIsbn, self::$_authorPattern1, 0), self::$_author1Pattern1, 0)),
            'year' => $this->accent($this->ParsData(self::$_yearPattern, $fichierIsbn, self::$_yearPattern1, 0)),
            'resume' => $this->accent($this->ParsData(self::$_resumePattern, $fichierGoogle, self::$_resumePattern1, 0)),
            'cover' => self::$_bookIsbn.$this->ParsData(self::$_coverPattern, $fichierIsbn, self::$_coverPattern1, 0),
            'collection' => $this->accent($this->ParsData(self::$_collectionPattern, $fichierIsbn, self::$_collectionPattern1, 0)),
            'note' => '',
            // 'note' => $this->litDonnees(self::$_notePattern, $fichierAmazon, self::$_notePattern1, 0),
            'isbn' => $isbn
        );
		
		// Fix a link problem with the external cover
		if(preg_match("#http://www.books-by-isbn.com/http:#", $livre['cover'])){
			$livre['cover'] = str_replace("http://www.books-by-isbn.com/", "", $livre['cover']);
		}
		
		$livre['resume'] = str_replace("\&quot;", '"', $livre['resume']);

        // Hydrate all data to the Book object
        $this->hydrate($livre);

    }

    public function outXml(){
        // Return a xml document for the AJAX parser
        if(is_numeric($this->_isbn) && !empty($this->_title)){
            $xml =	'<BookObject>
							<BookData>
								<Title>'.$this->_title.'</Title>
								<Author>'.$this->_author.'</Author>
								<Year>'.$this->_year.'</Year>
								<Publisher>'.$this->_collection.'</Publisher>
								<Cover>'.$this->_cover.'</Cover>
								<Description>'.$this->_resume.'</Description>
								<Isbn>'.$this->_isbn.'</Isbn>
								<Note>'.$this->_note.'</Note>
							</BookData>
						</BookObject>';
            return $xml;
        }
    }

    // Add a new book to the database
    public function add()
	{
        $q = $this->_db->prepare('
				INSERT INTO livres SET
				title = :title,
				author  = :author,
				genre = :genre,
				year = :year,
				resume = :resume,
				cover = :cover,
				note = :note,
				collection = :collection,
				isbn = :isbn
			');

        $q->bindValue(':title', $this->_title);
        $q->bindValue(':author', $this->_author);
        $q->bindValue(':genre', $this->_genre, PDO::PARAM_INT);
        $q->bindValue(':year', $this->_year, PDO::PARAM_INT);
        $q->bindValue(':resume', $this->_resume);
        $q->bindValue(':cover', $this->_cover);
        $q->bindValue(':note', $this->_note, PDO::PARAM_INT);
        $q->bindValue(':collection', $this->_collection);
        $q->bindValue(':isbn', $this->_isbn, PDO::PARAM_INT);

        $q->execute() OR DIE('<br /><span style="color: red; font-weight: bold;">A mistake happend when PHP was adding the element to the database...');

        // Add the ID value from the database to the object
		$this->_id = $this->_db->lastInsertId('id');
    }

	// Update a book to the database
    public function update()
    {
        $q = $this->_db->prepare('
            UPDATE livres SET
                title = :title,
                author = :author,
                genre = :genre,
                year = :year,
                resume = :resume,
                cover = :cover,
                note = :note,
                collection = :collection,
                isbn = :isbn
            WHERE id = :id');

        $q->bindValue(':title', $this->_title);
        $q->bindValue(':author', $this->_author);
        $q->bindValue(':genre', $this->_genre, PDO::PARAM_INT);
        $q->bindValue(':year', $this->_year, PDO::PARAM_INT);
        $q->bindValue(':resume', $this->_resume);
        $q->bindValue(':cover', $this->_cover);
        $q->bindValue(':note', $this->_note, PDO::PARAM_INT);
        $q->bindValue(':collection', $this->_collection);
        $q->bindValue(':isbn', $this->_isbn, PDO::PARAM_INT);
		$q->bindValue(':id', $this->_id, PDO::PARAM_INT);

        $q->execute();
    }

    // Instancie la connexion
    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }

    // Get a book from the database and hydrate the object which ask this function
    public function get($id)
    {
        $id = (int) $id;

        $q = $this->_db->query('SELECT * FROM livres WHERE id = '.$id);
        $donnees = $q->fetch(PDO::FETCH_ASSOC);
		if(!empty($donnees['id'])){
			$this->hydrate($donnees);
		}
    }
	
	// Delete a book from the database
    public static function deleteFromDb($db, $id)
    {
        $q = $db->exec('DELETE FROM livres WHERE id = '.$id);
    }
	
	
	// Return the complete list (array) of the book that are in the database
    public static function getList($db)
    {
        $livres = array();
	
        $q = $db->query('SELECT * FROM livres ORDER BY id');

        while($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $livre = new Livre($db);
			$livre->hydrate($donnees);
            $livres[] = $livre;
        }

        return $livres;
    }
	
	// Return the of the last book inserted
	public static function getLast($db)
	{
		$array = array();
        $q = $db->query('SELECT id FROM livres ORDER BY id');
        while($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $array[] = $donnees['id'];
        }
		if(!empty($array[0])){
			return max($array);
		}
	}
	
	// Return the list of x last book inserted
	public static function getListLast($db, $number)
	{
		$array = array();
		$q = $db->query('SELECT * FROM livres ORDER BY date DESC LIMIT 0,'.$number);
		while($donnees = $q->fetch(PDO::FETCH_ASSOC)){
			$livre = new Livre($db);
			$livre->hydrate($donnees);
			$array[] = $livre;
		}
		
		return $array;
	}
	
	// Check if the selected id is really in the database
	public static function isExist($db, $id)
	{
		$id = (int) $id;
		$livres = array();
        $q = $db->query('SELECT id FROM livres ORDER BY id');
        while($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $livre = new Livre($db);
			$livre->hydrate($donnees);
            $livres[] = $livre;
        }
		$array = array();
		for($i=0;$i<count($livres);$i++){
			$array[$i] = $livres[$i]->getId();
		}
		return (in_array($id, $array)) ? (true) : (false);
	}
	
	// Return the list of x books, ranged note
	public static function getByNote($db, $number)
	{
		$number = (int) $number;
		$livres = array();
		
        $q = $db->query('SELECT id, note FROM livres ORDER BY note DESC LIMIT '.$number);
		
        while($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $livre = new Livre($db);
			$livre->hydrate($donnees);
            $livres[] = $livre;
        }
		
        return $livres;
		
	}
	
	
	// Return the list of x books, ranged genre
	public static function getByGenre($db, $genre, $min, $max)
	{
		$livres = array();
		
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		// Sans limites aux bornes
			if($min == $max){
				$sql = "SELECT * FROM livres WHERE genre LIKE :genre";
				$stmt = $db->prepare($sql);
			}
			
		// Avec des limites aux bornes
			else{
				$sql = "SELECT * FROM livres WHERE genre LIKE :genre LIMIT :min,:max";
				$stmt = $db->prepare($sql);
				$stmt->bindParam(':min', $min, PDO::PARAM_INT);
				$stmt->bindParam(':max', $max, PDO::PARAM_INT);
			}
			
		
		$stmt->bindParam(':genre', $genre);
		$stmt->execute();
		
        while($donnees = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $livre = new Livre($db);
			$livre->hydrate($donnees);
            $livres[] = $livre;
        }
		
        return $livres;
		
	}	
	
	
	// Cut the resume to display it in the index page
	public function cutResume()
	{
		$lettres = strlen($this->_resume);
		$nb = 400;
		
		return ($lettres > $nb) ? (substr($this->_resume, 0, $nb - $lettres)) : ($this->_resume);
	}
	
	// Cut the title to display it in the index page
	public function cutTitle($nb)
	{
		$lettres = strlen($this->_title);
		return ($lettres > $nb) ? (substr($this->_title, 0, $nb - $lettres) . '...') : ($this->_title);
	}
    
	// Return a random id from the databse
	public static function plotBook($db)
	{
		$array = array();
        $q = $db->query('SELECT id FROM livres ORDER BY id');
        while($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $array[] = $donnees['id'];
        }
		if(!empty($array[0])){
			$a = rand(0, array_search(max($array), $array));
			return $array[$a];
		}
	}
	
	public static function getCategories($db)
	{
		$array = array();
		$q = $db->query('SELECT * FROM categories ORDER BY id');
		while($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$array[$donnees['id']] = $donnees['titre'];
		}
		return $array;
	}
	
	public static function truncateDb($db)
	{
	
		$q = $db->exec('TRUNCATE TABLE livres');
		$q = $db->exec('TRUNCATE TABLE favorite_books');
		$q = $db->exec('TRUNCATE TABLE mots_cles');
		return $db->errorInfo();
	
	}
	
	public static function getFavorite($db, $nb)
	{
   
		$array = array();
		$q = $db->query('SELECT * FROM favorite_books LIMIT '.$nb);
		while($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$array[] = $donnees['id_livre'];
		}
		
		return $array;
	}
	
	public static function numberBook($db)
	{
		$q = $db->query('SELECT id FROM livres');
		$q = $q->fetchAll();
		return count($q);
	}
	
	public static function search($db, $search)
	{
		$array = array();
		$search = '%'.$search.'%';
		$q = $db->prepare('SELECT id FROM livres WHERE title LIKE ? OR author LIKE ? OR resume LIKE ? OR collection LIKE ?');
		$q->execute(array($search, $search, $search, $search));
		while($donnees = $q->fetch())
		{
			$array[] = $donnees['id'];
		}
		return $array;
	}
	
	
	public static function searchBy($db, $search)
	{
		$array = array();
		
		$q = $db->prepare('SELECT id FROM livres WHERE isbn LIKE ? AND title LIKE ? AND author LIKE ? AND year LIKE ? AND collection LIKE ? AND resume LIKE ?');
		$q->execute(array($search['isbn'], $search['title'], $search['author'], $search['year'], $search['collection'], $search['resume']));
		while($donnees = $q->fetch())
		{
			$array[] = $donnees['id'];
		}
		return $array;
	}
	
}

?>