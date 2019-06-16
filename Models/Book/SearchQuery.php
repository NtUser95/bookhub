<?php

namespace Models\Book;

use App\App;
use Models\Util;

class SearchQuery
{
    /** @var string */
    private $_tableName;
    /** @var array */
    private $_filters = [];
    /** @var array */
    private $_sort = [];
    /** @var int */
    private $_limit;
    /** @var int */
    private $_offset;
    /** @var array */
    private $_groupBy = [];

    public function __construct($tableName)
    {
        $this->_tableName = $tableName;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->_tableName;
    }

    public function addSort($sortKey, $sortType)
    {
        $this->_sort[] = [
            $sortKey => $sortType,
        ];
    }

    public function addFilter($filterKey, $filterValue)
    {
        $this->_filters[] = [
            $filterKey, $filterValue,
        ];
    }

    public function setLimit($limit)
    {
        $this->_limit = $limit;
    }

    public function setOffset($offset)
    {
        $this->_offset = $offset;
    }

    public function setGroupBy($fields = [])
    {
        $this->_groupBy = $fields;
    }

    private function _prepareWhere()
    {
        $bindedValues = [];
        $query = '';
        if ($this->_filters) {
            $queries = [];
            foreach ($this->_filters as $filterRule) {
                [$filterKey, $filterValue] = $filterRule;
                if (is_array($filterValue) && count($filterValue) > 1) {
                    $markers = array_fill(0, count($filterValue), '?');
                    $queries[] = '`' . Util::clearString($filterKey) . '` IN (' . implode(',', $markers) . ')';
                    $bindedValues = array_merge($bindedValues, $filterValue);
                } else {
                    $queries[] = '`' . Util::clearString($filterKey) . '` = ?';
                    $bindedValues[] = $filterValue;
                }
            }

            $query .= implode(' AND ', $queries);
        }

        if ($this->_sort) {
            $fQuery = [];
            $fBinded = [];
            foreach ($this->_sort as $filterKey => $filterValue) {
                $fQuery[] = '`' . Util::clearString($filterKey) . '` ?';
                $fBinded[] = $filterValue;
            }
            $query .= ' ORDER BY ' . implode(', ', $fQuery);
            $bindedValues = array_merge($bindedValues, $fBinded);
        }

        return [
            'query' => $query,
            'values' => $bindedValues,
        ];
    }

    private function _prepareLimit()
    {
        $query = '';
        $bindedValues = [];

        if ($this->_limit && !$this->_offset) {
            $query .= '?';
            $bindedValues[] = $this->_limit;
        } else if ($this->_limit && $this->_offset) {
            $query .= '? , ?';
            $bindedValues[] = (int)$this->_offset;
            $bindedValues[] = (int)$this->_limit;
        }

        return [
            'query' => $query,
            'values' => $bindedValues,
        ];
    }

    private function _prepareGroup()
    {
        $query = '';
        if ($this->_groupBy) {
            $filteredValues = [];
            foreach ($this->_groupBy as $field) {
                $filteredValues[] = Util::clearString($field);
            }
            $query .= implode(', ', $filteredValues);
        }

        return [
            'query' => $query,
            'values' => [],
        ];
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $sql = 'SELECT * FROM `' . $this->getTableName() . '`';
        $values = [];
        $preparedWhere = $this->_prepareWhere();
        if ($preparedWhere['query']) {
            $sql .= ' WHERE ' . $preparedWhere['query'];
            $values = array_merge($values, $preparedWhere['values']);
        }
        $prepareGroup = $this->_prepareGroup();
        if ($prepareGroup['query']) {
            $sql .= ' GROUP BY ' . $prepareGroup['query'];
        }
        $preparedLimit = $this->_prepareLimit();
        if ($preparedLimit['query']) {
            $sql .= ' LIMIT ' . $preparedLimit['query'];
            $values = array_merge($values, $preparedLimit['values']);
        }

        return App::$db->execute($sql, $values);
    }
}