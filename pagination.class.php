<?php
class Pagi{
	var $totalPage;		
	var $currPage;

	//-> Settings
	var $pageLimit = 4;
	var $pageGetVar = 'page';       //-> Url pagination parameter name
	var $showFirstLast = true;      //-> First - Last button show status
	var $showPrevNext = true;       //-> Previous - Next button show status
	var $showInput = true;          //-> Text - Number box show status
	var $currLang = 'tr';           //-> Default language code
	
	var $lang = array(
		'tr' => array('first' => '« İlk', 'last' => 'Son »', 'prev' => 'Önceki', 'next' => 'Sonraki', 'space_first' => '...', 'space_last' => '...'),
		'en' => array('first' => '« First', 'last' => 'Last »', 'prev' => 'Previous', 'next' => 'Next', 'space_first' => '...', 'space_last' => '...'),
		'fr' => array('first' => '« Première', 'last' => 'Finir »', 'prev' => 'Précédentes', 'next' => 'Suivantes', 'space_first' => '...', 'space_last' => '...'),
		'de' => array('first' => '« Zuerst', 'last' => 'Ende »', 'prev' => 'Vorherige', 'next' => 'Nächste', 'space_first' => '...', 'space_last' => '...'),
	);
	
	function __construct($totalPage=1, $pageGetVar='page', $lang = 'tr'){
		$this->totalPage = $totalPage;
		if(isset($this->lang[$lang])){
			$this->currLang = $lang;
		}
		else{
			$this->currLang = array_key_first($this->lang);
		}
		$this->pageGetVar = $pageGetVar;
		if(isset($_GET[$this->pageGetVar])){			
			$this->currPage = intval($_GET[$this->pageGetVar]);
		}
		if($this->currPage < 1){
			$this->currPage = 1;
		}
	}

	function setTotalPage($total = 0){
		$this->totalPage = $total;
	}

	function setPageLimit($pageLimit = 0){
		$this->pageLimit = $pageLimit;
	}

	function setPageGetVar($pageVar = 'page'){
		$this->pageGetVar = $pageVar;
	}

	function setCurrLang($lang = ''){
		$this->currLang = $lang;
	}

	function showFirstLast(){
		$this->showFirstLast = true;
	}

	function hideFirstLast(){
		$this->showFirstLast = false;
	}

	function showPrevNext(){
		$this->showPrevNext = true;
	}

	function hidePrevNext(){
		$this->showPrevNext = false;
	}
	
	function setUrl($page = 1){
		$get = $_GET;
		if(count($get) > 0){
			$url = array();
			if(!isset($get[$this->pageGetVar])){
				$url[] = $this->pageGetVar . '=' . $page;
			}
			foreach($get as $k=>$v){
				if($k == $this->pageGetVar){
					$url[] = $k . '=' . $page;
				}
				else{
					$url[] = $k . '=' . $v;
				}
			}
			return '?'.implode('&', $url);
		}
		else{
			return '?' . $this->pageGetVar . '=' . $page;
		}
	}
	
	function getLangText($key){
		if(isset($this->lang[$this->currLang][$key])){
			return $this->lang[$this->currLang][$key];			
		}
		else{
			return $key;
		}
	}
	
	function getContent(){
		$cont = array();
		if($this->totalPage > 1){
			if($this->pageLimit > 0){
				if($this->currPage > $this->pageLimit and $this->currPage < $this->totalPage - $this->pageLimit){
					$first = $this->currPage - $this->pageLimit;
					if($first == 1)
						$last = ($this->pageLimit * 2) + 1;
					else
						$last = $this->currPage + $this->pageLimit;
				}
				else if($this->currPage <= $this->pageLimit){
					$first = 1;
					$last = ($this->pageLimit * 2) + 1;
					if($last > $this->totalPage){
						$last = $this->totalPage;
					}
				}
				else if($this->currPage + $this->pageLimit >= $this->totalPage){
					$last = $this->totalPage;
					$first = $this->totalPage - ($this->pageLimit * 2);
					if($first < 1){
						$first = 1;
					}
				}
			}

			for($p = $first; $p <= $last; $p++){
				if($p == $first and !isset($cont['first'])){
					#-> İlk linki ekleme
					if($this->showFirstLast){	
						$active = '';
						if($this->currPage == $p){
							$active = 'active';
						}
						$cont['first'] = array('url' => $this->setUrl(1), 'active' => $active);
					}
					
					#-> Önceki linki ekleme
					if($this->showPrevNext){	
						$active = '';
						if($this->currPage == $first){
							$active = 'active';
						}
						if($this->currPage == $first){
							$cont['prev'] = array('url' => $this->setUrl($p), 'active' => $active);
						}
						else{
							$cont['prev'] = array('url' => $this->setUrl($this->currPage - 1), 'active' => $active);
						}
					}
					
					#-> Boşluk ekleme
					if( $this->pageLimit > 0 and
						($this->pageLimit * 2) + 1 < $this->totalPage and
						$this->currPage > $this->pageLimit and
						$this->currPage - $this->pageLimit > 1
					){
						$cont['space_first'] = array('url' => $this->setUrl(0), 'active' => 'active');
					}
				}
				
				
				$active = '';
				if($p == $this->currPage){
					$active = 'active';
				}
				$cont[$p] = array('url' => $this->setUrl($p), 'active' => $active);
				
				
				
				
				
				if($p == $last){	
					#-> Boşluk ekleme
					if( $this->pageLimit > 0 and
						($this->pageLimit * 2) + 1 < $this->totalPage and
						$this->currPage < $this->totalPage - $this->pageLimit
					){
						$cont['space_last'] = array('url' => $this->setUrl(0), 'active' => 'active');
					}
					
					#-> Sonraki linki ekleme
					if(!isset($cont['next']) and $this->showPrevNext){	
						$active = '';
						if($this->currPage == $last){
							$active = 'active';
						}
						if($this->currPage == $last){
							$cont['next'] = array('url' => $this->setUrl($p), 'active' => $active);
						}
						else{						
							$cont['next'] = array('url' => $this->setUrl($this->currPage + 1), 'active' => $active);
						}
					}
					
					#-> Son linki ekleme
					if($this->showFirstLast){
						$active = '';
						if($this->currPage == $p){
							$active = 'active';
						}
						$cont['last'] = array('url' => $this->setUrl($this->totalPage), 'active' => $active);
					}
				}
			}

			$disp = array();
			foreach($cont as $pp => $vv){
				if($vv['active'] == ''){
					$disp[] = '<li><a href="' . $vv['url'] . '">'.$this->getLangText($pp).'</a></li>';
				}
				else{
					if(in_array($pp, array('space_first', 'space_last'))){
						$disp[] = '<li><span class="spacer">'.$this->getLangText($pp).'</span></li>';						
					}
					else{
						$disp[] = '<li><span>'.$this->getLangText($pp).'</span></li>';						
					}
				}
			}

			if($this->showInput) {
				$disp = array_merge(array("<li><input type='number' value='" . $this->currPage . "' onChange='var wl1 = window.location; var upr = new URLSearchParams(wl1.search); upr.set(\"" . $this->pageGetVar . "\", this.value); window.location = wl1.origin + wl1.pathname + \"?\" + upr.toString();'></li>"), $disp);
			}
			return "<ul class='pagination'>\n" . implode("\r\n", $disp) . "\n</ul>";
		}
		else{
			return '';
		}
	}
}