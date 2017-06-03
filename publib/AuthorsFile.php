<?php
class AuthorsFile
{
	private $_xmlFile;
	
	function AuthorsFile($xmlFile)
	{
		$this->_xmlFile = $xmlFile;
	}
	
	function GetKnownAuthors()
	{
		$knownAuthorsXml = simplexml_load_file($this->_xmlFile);
		foreach($knownAuthorsXml->AuthorInfo as $author)
		{
			$knownAuthor = new Author($author);
			$knownAuthors[$knownAuthor->Name] = $knownAuthor;
		}
		return $knownAuthors;
	}
}
?>