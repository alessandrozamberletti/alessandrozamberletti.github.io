<?php
$pubLibPath = "publib/";

require $pubLibPath . "Author.php";
require $pubLibPath . "AuthorsFile.php";
require $pubLibPath . "Publication.php";
require $pubLibPath . "PublicationsFile.php";

class PublicationList
{
	var $PublicationsFile;
	var $Filter;

	function PublicationList($publicationsFile, $publicationFilter)
	{
		$this->PublicationsFile = $publicationsFile;
		$this->Filter = $publicationFilter;
	}

	function cmp($a, $b)
	{
	    return -1*strcmp($a->Year, $b->Year);
	}

	

	
	function GetPublicationsHtml() 
	{
		$publications = $this->PublicationsFile->GetPublications();
		usort($publications, array( $this, 'cmp' ));

		$currentYear = '';
		$html .= '<dl>';
		foreach($publications as $pub)
		{
			if (! $this->Filter->ToBeIncluded($pub))
			{
				continue;
			}
			$year = $pub->Year;
			if($year != $currentYear)
			{
				$currentYear = $year;
				$html .= '<dt><h3>' . $currentYear . '</h3></dt>';
			}
			$html .=  	'<dd>' .
							$this->RenderAuthors($pub) .
							$this->RenderTitle($pub) .
							$this->RenderBook($pub) .
							$this->RenderPages($pub) .
							$this->RenderLocation($pub) .
							$this->RenderYear($pub) .
							'<br />' .
							$this->RenderResources($pub) .
						'</dd>';
		}
		$html .= '</dl>';
		
		
		return $html;
	}
	
	function RenderResources($publication)
	{
		$resourcesHtml = $this->RenderPdfUrl($publication) .
				 $this->RenderDOIUrl($publication) .
				 $this->RenderBibTexUrl($publication) .
				 $this->RenderDownloadsUrl($publication) .
				 $this->RenderDatasetUrl($publication) . 
				 $this->RenderOther($publication);
		if (strlen($resourcesHtml) > 0)
		{
			return $resourcesHtml;
		}
		return '';					
	}
	
	function RenderAuthors($publication)
	{
		$authors = $publication->GetAuthors();
		$authorCount = count($authors);
		$html = '';
		for($authorId = 0; $authorId < $authorCount; $authorId++)
		{  
			$author = $authors[$authorId];
			if (isset($author->Url))
			{
				$html .=  '<a class="hidden" target="_blank" href="' . $author->Url . '">' . $author->Name . '</a>';
			}
			else
			{
				$html .=  $author->Name;
			}
			
			if ($authorId < $authorCount - 1) 
			{
				$html .=  ', ';
			}
		}
		return $html;
	}
	
	function RenderTitle($publication)
	{
		return '. <b><em>' . $publication->Title . '.</em></b> ';
	}
	
	function RenderBook($publication)
	{
		return 'In ' . $publication->Book . ', ';
	}
	
	function RenderPages($publication)
	{
		if (!empty($publication->Pages))
		{
			return 'pages ' . $publication->Pages . ', ';
		}
		return '';
	}
	
	function RenderLocation($publication)
	{
		if (!empty($publication->Location))
		{
			return $publication->Location . ', ';
		}
		return '';
	}
	
	function RenderYear($publication)
	{
		if (!empty($publication->Year))
		{
			return $publication->Year . '.';
		}
		return '';
	}
	
	function RenderDOIUrl($publication)
	{
		if (!empty($publication->DOIUrl))
		{
			return '[<a target="_blank" href="' . $publication->DOIUrl . '">DOI</a>] ';
		}
		return '';
	}
	
	function RenderBibTexUrl($publication)
	{
		if (!empty($publication->BibTexUrl))
		{
			return '[<a target="_blank" href="' . $publication->BibTexUrl . '">BibTex</a>] ';
		}
		return '';
	}
	
	function RenderPdfUrl($publication)
	{
		if (!empty($publication->PdfUrl))
		{
			return '[<a target="_blank" href="' . $publication->PdfUrl . '">Pdf</a>] ';
		}
		return '';
	}
	
	function RenderDatasetUrl($publication)
	{
		if (!empty($publication->DatasetUrl))
		{
			return '[<a target="_blank" href="' . $publication->DatasetUrl . '">Dataset</a>] ';
		}
		return '';
	}

	function RenderDownloadsUrl($publication)
	{
		if (!empty($publication->DownloadsUrl))
		{
			return '[<a target="_blank" href="' . $publication->DownloadsUrl . '">Software</a>] ';
		}
		return '';
	}

	function RenderOther($publication)
	{
		if (!empty($publication->Other))
		{
			return ' [<a target="_blank" href="' . $publication->Other . '">' . $publication->OtherType . '</a>]';
		}
		return '';
	}
	
}
?>
