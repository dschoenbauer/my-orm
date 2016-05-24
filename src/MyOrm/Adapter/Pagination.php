<?php

namespace CTIMT\MyOrm\Adapter;

use CTIMT\MyOrm\Enum\Defaults;
use CTIMT\MyOrm\Enum\LayoutKeys;
use CTIMT\MyOrm\Enum\ModelAttributes;
use CTIMT\MyOrm\Enum\ModelEvents;
use CTIMT\MyOrm\Enum\PaginatedReponseKeys;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelVisitorInterface;
use CTIMT\MyOrm\Model\ObserverInterface;
use CTIMT\MyOrm\Tools\ArrayUtilities;
use CTIMT\MyOrm\Tools\Server;
use PDO;

/*
 * Copyright 2015 Coe-Truman International.
 */

/**
 * 
  $this->setPageSize(filter_input(INPUT_GET, PaginatedReponseKeys::PARAMETER_PAGE_SIZE, FILTER_SANITIZE_NUMBER_INT)? : $this->getPageSize());
  $this->setPage(filter_input(INPUT_GET, PaginatedReponseKeys::PARAMETER_PAGE, FILTER_SANITIZE_NUMBER_INT)? : $this->getPage());

 * Description of PdoPaginatedResponse
 * @author David
 */
class Pagination implements SelectVisitorInterface, ModelVisitorInterface, ObserverInterface {

    const PARAM_KEY = 'pagination';

    private $pageSize = 50;
    private $page = 1;
    private $totalResults = 0;
    private $totalPages = 1;

    public function visitSelect(Select $select) {
        $select->setSqlCalcFoundRows()->setLimit($this->getPageSize() * ($this->getPage() - 1), $this->getPageSize());
    }

    public function visitModel(Model $model) {
        $model->attach($this);
        $userInput = $model->getAttribute(ModelAttributes::PAGE, Defaults::PAGE);
        $page = array_key_exists(PaginatedReponseKeys::KEY_PAGE_CURRENT, $userInput) ? $userInput[PaginatedReponseKeys::KEY_PAGE_CURRENT] : Defaults::PAGE;
        $pageSize = array_key_exists(PaginatedReponseKeys::KEY_PAGE_SIZE, $userInput) ? $userInput[PaginatedReponseKeys::KEY_PAGE_SIZE] : Defaults::PAGE_SIZE;
                
        $this->setPage($page)->setPageSize($pageSize);
    }
    
    public function update(Model $model, $eventName) {
        if($eventName == ModelEvents::LAYOUT_COLLECTION_APPLIED){
            $this->addMetaInformationToLayout($model);
        }
        if($eventName == ModelEvents::PRIMARY_DATA_PULLED){
            $this->setTotals($model->getQuery()->getAdapter());
        }
        
    }
    
    public function addMetaInformationToLayout(Model $model) {
        $data = $model->getData();
        //$data[LayoutKeys::META_KEY] = array_merge((array_key_exists(LayoutKeys::META_KEY, $data) ? $data[LayoutKeys::META_KEY] : []), $this->getMeta($model));
        $data[LayoutKeys::LINK_KEY] = $this->getLinks($model, $this->getPage(), $this->getTotalPages(), PaginatedReponseKeys::KEY_PAGE_CURRENT);
        $data[LayoutKeys::META_KEY][PaginatedReponseKeys::PARAMETER_PAGE] = $this->getMeta($model);
        $data[LayoutKeys::META_KEY][PaginatedReponseKeys::KEY_TOTAL_ITEMS] = (int) $this->getTotalResults();
        $model->setData($data);

    }

    public function setTotals(PDO $adapter) {
        $this->setTotalResults($adapter->query('SELECT FOUND_ROWS();')->fetch(PDO::FETCH_COLUMN));
        $this->setTotalPages(ceil($this->getTotalResults() / $this->getPageSize()));
        return $this;
    }

    private function getMeta($model) {
        $pageRecords = count($model->getData()[$model->getEntity()->getName()]);
        return [
            PaginatedReponseKeys::KEY_PAGE_CURRENT => (int) $this->getPage(),
            PaginatedReponseKeys::KEY_PAGE_COUNT => (int) $this->getTotalPages(),
            PaginatedReponseKeys::KEY_PAGE_SIZE => (int) $pageRecords, //$this->getPageSize();
        ];
    }

    private function getLinks(Model $model, $currentPage, $maxPages, $pageKey, $minPages = 1) {
        $previous = ($currentPage - 1 < $minPages ? $minPages : $currentPage - 1 );
        $next = ($currentPage + 1 > $maxPages ? $maxPages : $currentPage + 1);
        $get = array_map(function($a) {
            return $a->getValue();
        }, $model->getAttribute(ModelAttributes::_GET));
        return [
            LayoutKeys::IRL_PREVIOUS => Server::getRelativePath(ArrayUtilities::ModifyAndReturn($get, $pageKey, $previous)),
            LayoutKeys::IRL_CURRENT => Server::getRelativePath(ArrayUtilities::ModifyAndReturn($get, $pageKey, $currentPage)),
            LayoutKeys::IRL_NEXT => Server::getRelativePath(ArrayUtilities::ModifyAndReturn($get, $pageKey, $next)),
        ];
    }

    public function getPageSize() {
        return $this->pageSize;
    }

    public function getPage() {
        return $this->page;
    }

    public function getTotalResults() {
        return $this->totalResults;
    }

    public function getTotalPages() {
        return $this->totalPages;
    }

    public function setPageSize($pageSize) {
        $this->pageSize = $pageSize ? : $this->getPageSize();
        return $this;
    }

    public function setPage($page) {
        $this->page = $page ? : $this->getPage();
        return $this;
    }

    public function setTotalResults($totalResults) {
        $this->totalResults = $totalResults;
        return $this;
    }

    public function setTotalPages($totalPages) {
        $this->totalPages = $totalPages;
        return $this;
    }

}
