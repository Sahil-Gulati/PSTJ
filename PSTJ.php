<?php
ini_set('display_errors', 1);
/**
 * @author Sahil Gulati <sahil.gulati1991@outlook.com> 
 */

echo printr_source_to_json(
        print_r(
                array("Name"=>"Sahil Gulati",
                      "Education"=>array(
                          "From"=>array(
                              "DU"=>array(
                                  "Course"=>"B.Sc. (Hons.) Computer Science.")
                              )
                          )
                    )
                , true
                )
        );

/**
 * This function will convert output string of `print_r($array)` to `json string`
 * @note Exceptions are always there i tried myself best to get it done. Here $array can be array of arrays or arrays of objects or both
 * @param String $string This will contain the output of `print_r($array)` (which user will get from ctrl+u of browser),
 * @return String
 */
function printr_source_to_json($string)
{
    /**
     *replacing `stdClass Objects (` to  `{`
     */
    $string = preg_replace("/stdClass Object\s*\(/s", '{  ', $string);
    
    /**
     *replacing `Array (` to  `{`
     */
    $string = preg_replace("/Array\s*\(/s", '{  ', $string);

    /**
     *replacing `)\n` to  `},\n`
     * @note This might append , at the last of string as well 
     * which we will trim later on.
     */
    $string = preg_replace("/\)\n/", "},\n", $string);
    
    /**
     *replacing `)` to  `}` at the last of string
     */
    $string = preg_replace("/\)$/", '}', $string);

    /**
     *replacing `[ somevalue ]` to "somevalue"
     */
    $string = preg_replace("/\[\s*([^\s\]]+)\s*\](?=\s*\=>)/", '"\1" ', $string);

    /**
     * replacing `=> {`  to `: {`
     */
    $string = preg_replace("/=>\s*{/", ': {', $string);

    /**
     * replacing empty last values of array special case `=> \n }` to : "" \n
     */
    $string = preg_replace("/=>\s*[\n\s]*\}/s", ":\"\"\n}", $string);
    
    /**
     * replacing `=> somevalue`  to `: "somevalue",` 
     */
    $string = preg_replace("/=>\s*([^\n\"]*)/", ':"\1",', $string);

    /**
     * replacing last mistakes `, }` to `}` 
     */
    $string = preg_replace("/,\s*}/s", '}', $string);

    /**
     * replacing `} ,` at the end to `}`
     */
    return $string = preg_replace("/}\s*,$/s", '}', $string);
}
