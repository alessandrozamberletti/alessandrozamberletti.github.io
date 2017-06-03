<?php
class PublicationsFile
{
	private $_publictationsXmlFile;
	private $_authorsFile;
	
	function PublicationsFile($publictationsXmlFile, $authorsFile)
	{
		$this->_publictationsXmlFile = $publictationsXmlFile;
		$this->_authorsFile = $authorsFile;
	}
	
	function GetPublications()
	{
		$knownAuthors = $this->_authorsFile->GetKnownAuthors();
		$publicationsXml = simplexml_load_file($this->_publictationsXmlFile);
			
		foreach($publicationsXml->Publication as $publicationNode)
		{	
			$publications[] = new Publication($publicationNode, $knownAuthors);
		}
		return $publications;
	}


}
?>
