<?php
	class GalloFilter
	{
		function ToBeIncluded($publication)
		{
			$authors = $publication->GetAuthors();
			foreach($authors as $author)
			{
				if ($author->Name === "Ignazio Gallo")
				{
					return true;
				}
			}
			return false;
		}
	}
?>
