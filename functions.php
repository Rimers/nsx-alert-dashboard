<?php

## This code is written by Soren Isager @ sorenisager.com 2020
## This code is licenced under MIT License
## APP: FUNCTIONS FILE

function FindFieldValue($Data, $Needle)
	{
		foreach ($Data as $Value)
			{
				if ($Value["name"] == $Needle)
					{
						return $Value["content"];
					}
			}

		return "";
	}

function ReverseLookup($ip)
	{
		global $ReverseLookupJsonFileData;
		
		if ($ReverseLookupJsonFileData[$ip])
			{
				return $ReverseLookupJsonFileData[$ip];
			}
		else
			{
				return "";
			}
	}

?>