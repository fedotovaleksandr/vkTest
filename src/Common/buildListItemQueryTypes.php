<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 06.01.2016
 * Time: 20:35
 */
function buildQueryforIdField($queryParams)
{
    $fastQuery = null;
    switch ($queryParams['start']) {
        //first page
        case 0 : {
            $fastQuery = 'SELECT ' . implode(",", $queryParams['queryAssoc']['query']['select']) . ' FROM ' .
                $queryParams['table']['name'] . ' ORDER BY ' . $queryParams['orderColumn'] . ' ' .
                $queryParams['orderDir'] . ' LIMIT ' . $queryParams['length'];
            break;
        }
        //last page
        case $queryParams['lastPage'] : {

            $subdir = strtoupper($queryParams['orderDir']) == 'DESC' ? 'ASC' : 'DESC';

            $queryParams['itemsLast'] = ($queryParams['itemsLast'] == 0) ? $queryParams['length'] : $queryParams['itemsLast'];

            $fastQuery = 'SELECT * FROM (SELECT ' . implode(",", $queryParams['queryAssoc']['query']['select']) . ' FROM ' .
                $queryParams['table']['name'] . ' ORDER BY ' . $queryParams['orderColumn'] . ' ' . $subdir . ' LIMIT ' .
                $queryParams['itemsLast'] . ') as tmp ORDER BY tmp.iditem ' . $queryParams['orderDir'];
            break;
        }
        default: {
            //next

            if (!empty($queryParams['list']))

                if ($queryParams['list']['slowQueryType'] == $queryParams['slowQueryType']) {
                    $subdir = strtoupper($queryParams['orderDir']) == 'DESC' ? 'ASC' : 'DESC';
                    $sign = strtoupper($queryParams['orderDir']) == 'DESC' ? ' > ' : '<';
                    if (abs($queryParams['start'] - $queryParams['list']['lastpage']) == $queryParams['length']) {
                        if ($queryParams['list']['lastpage'] < $queryParams['start']) {
                            //next
                            $whereClause = '(' . $queryParams['list']['lastitem'][$queryParams['orderColumn']] . $sign . $queryParams['orderColumn'] . ' )';
                            $fastQuery = 'SELECT ' . implode(",", $queryParams['queryAssoc']['query']['select']) . ' FROM ' .
                                $queryParams['table']['name'] . ' WHERE ' . $whereClause . ' ORDER BY ' .
                                $queryParams['orderColumn'] . ' ' . $queryParams['orderDir'] . ' LIMIT ' . $queryParams['length'];
                        }
                        if ($queryParams['list']['lastpage'] > $queryParams['start']) {
                            //prev
                            $whereClause = '(' . $queryParams['orderColumn'] . $sign . $queryParams['list']['firstitem'][$queryParams['orderColumn']] . ' )';
                            $fastQuery = 'SELECT * FROM (SELECT ' . implode(",", $queryParams['queryAssoc']['query']['select']) .
                                ' FROM ' . $queryParams['table']['name'] . ' WHERE ' . $whereClause . ' ORDER BY ' .
                                $queryParams['orderColumn'] . ' ' . $subdir . ' LIMIT ' . $queryParams['length'] .
                                ') as tmp ORDER BY tmp.iditem ' . $queryParams['orderDir'];

                        }
                    }
                }
        }
    }
    return $fastQuery;
}

;
function buildQueryforAnotherField($queryParams)
{


    $fastQuery = null;
    $orderClause = ',iditem';
    switch ($queryParams['start']) {
        //first page
        case 0 : {
            $fastQuery = 'SELECT ' . implode(",", $queryParams['queryAssoc']['query']['select']) . ' FROM ' .
                $queryParams['table']['name'] . ' ORDER BY ' . $queryParams['orderColumn'] . ' ' . $queryParams['orderDir'] .
                $orderClause . ' LIMIT ' . $queryParams['length'];
            break;
        }
        //last page
        case $queryParams['lastPage'] : {
            $subdir = strtoupper($queryParams['orderDir']) == 'DESC' ? 'ASC' : 'DESC';
            $orderClause = $orderClause . ' DESC';
            $queryParams['itemsLast'] = ($queryParams['itemsLast'] == 0) ? $queryParams['length'] : $queryParams['itemsLast'];
            $fastQuery = 'SELECT * FROM (SELECT ' . implode(",", $queryParams['queryAssoc']['query']['select']) . ' FROM ' .
                $queryParams['table']['name'] . ' ORDER BY ' . $queryParams['orderColumn'] . ' ' . $subdir . $orderClause .
                ' LIMIT ' . $queryParams['itemsLast'] . ') as tmp ORDER BY tmp.iditem ASC';
            break;
        }
        default: {
            //next
            if (!empty($queryParams['list']))
                if ($queryParams['list']['slowQueryType'] == $queryParams['slowQueryType']) {
                    $sign = strtoupper($queryParams['orderDir']) == 'DESC' ? ' > ' : '<';
                    if (abs($queryParams['start'] - $queryParams['list']['lastpage']) == $queryParams['length']) {
                        if ($queryParams['list']['lastpage'] < $queryParams['start']) {
                            //next

                            $whereClause = '(' . $queryParams['list']['lastitem'][$queryParams['orderColumn']] . $sign .
                                $queryParams['orderColumn'] . ' ) OR (' . $queryParams['orderColumn'] . ' = ' .
                                $queryParams['list']['lastitem'][$queryParams['orderColumn']] . ' AND iditem > ' .
                                $queryParams['list']['lastitem']['iditem'] . ')';
                            $fastQuery = 'SELECT ' . implode(",", $queryParams['queryAssoc']['query']['select']) . ' FROM ' .
                                $queryParams['table']['name'] . ' WHERE ' . $whereClause . ' ORDER BY ' .
                                $queryParams['orderColumn'] . ' ' . $queryParams['orderDir'] . $orderClause . ' LIMIT ' .
                                $queryParams['length'];
                        }
                        if ($queryParams['list']['lastpage'] > $queryParams['start']) {
                            //prev
                            $subdir = strtoupper($queryParams['orderDir']) == 'DESC' ? 'ASC' : 'DESC';
                            $orderClause = $orderClause . ' DESC';
                            $whereClause = '(' . $queryParams['orderColumn'] . $sign .
                                $queryParams['list']['firstitem'][$queryParams['orderColumn']] . ' ) OR (' .
                                $queryParams['orderColumn'] . ' = ' . $queryParams['list']['firstitem'][$queryParams['orderColumn']] .
                                ' AND iditem < ' . $queryParams['list']['firstitem']['iditem'] . ')';
                            $fastQuery = 'SELECT * FROM ( SELECT ' . implode(",", $queryParams['queryAssoc']['query']['select']) .
                                ' FROM ' . $queryParams['table']['name'] . ' WHERE ' . $whereClause . ' ORDER BY ' .
                                $queryParams['orderColumn'] . ' ' . $subdir . $orderClause . ' LIMIT ' . $queryParams['length'] .
                                ') as tmp ORDER BY tmp.iditem ASC,' . 'tmp.' . $queryParams['orderColumn'] . ' ' . $queryParams['orderDir'];

                        }
                    }
                }
        }
    }
    return $fastQuery;

}

;

