<?php
class Publication
{
	private $_knownAuthors;
	private $_authorNodes;
	private $_tagNodes;
	
	var $Title;
	var $Book;
	var $Year;
	var $Pages;
	var $Location;
	var $DOIUrl;
	var $PdfUrl;
	var $BibTexUrl;
	var $DatasetUrl;
	var $DownloadsUrl;
	var $Other;
	var $OtherType;
	
	function GetAuthors()
	{
		foreach($this->_authorNodes as $authorNode) 
		{
			$authorName = (string)$authorNode;
			
			if (array_key_exists($authorName, $this->_knownAuthors))
			{
				$authors[] = $this->_knownAuthors[(string)$authorNode];
			}
			else
			{
				$authors[] = new Author($authorName);
			}
		}	
		
		return $authors;
	}
	
	function GetTags()
	{
		$tags = array();
		
		if (isset($this->_tagNodes))
		{
			foreach($this->_tagNodes as $tagNode)
			{
				$tags[] = (string)$tagNode;
			}
		}
		return $tags;
	}
	
	function Publication($publicationNode, $knownAuthors)
	{
		$this->_knownAuthors = $knownAuthors;
		$this->_authorNodes = $publicationNode->Authors->Author;
		$this->Title = (string)$publicationNode->Title;
		$this->Book = (string)$publicationNode->Book;
		$this->Year = (string)$publicationNode->Year;
		$this->Pages = (string)$publicationNode->Pages;
		$this->Location = (string)$publicationNode->Location;
		$this->DOIUrl = (string)$publicationNode->DOIUrl;
		$this->PdfUrl = (string)$publicationNode->PdfUrl;
		$this->BibTexUrl = (string)$publicationNode->BibTexUrl;
		$this->DatasetUrl = (string)$publicationNode->DatasetUrl;
		$this->DownloadsUrl = (string)$publicationNode->DownloadsUrl;
		$this->Other = (string)$publicationNode->Other;
		if($this->Other!="")
		{		
			$this->OtherType = (string)$publicationNode->Other->attributes();
		}
		$this->_tagNodes = $publicationNode->Tags->Tag;
	}
}
?>
