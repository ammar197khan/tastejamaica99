<?php
	class Paging {
		private $query;
		private $db;
		private $current_page;
		private $results_per_page;
		
		private $total_records;
		private $total_pages;
		
		function count_pages($db, $query, $results_per_page=15, $arr=''){
			$this->db=$db;
			$this->query=$query;
			
			$current_page=isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
			$this->current_page= $current_page<1 ? 1 : $current_page;
			$this->results_per_page=$results_per_page;
			
			$result=$this->db->select($this->query, $arr);
			$this->total_records=$this->db->num_rows($result);
			$this->total_pages=ceil($this->total_records/$this->results_per_page);
		}
		function get_start(){
			$start=($this->current_page-1)*$this->results_per_page;
			return $start;
		}
		function get_total_records(){
			return $this->total_records;
		}
		function get_total_pages(){
			return $this->total_pages;
		}
		function render_pages($b=false){
			echo "<ul class='pagination paging'>";
			// $grace pages on the left and $grace pages on the right of current page
			$grace=3;						
			$range=$grace*2;

			$start  = ($this->current_page - $grace) > 0 ? ($this->current_page - $grace) : 1;
			$end=$start + $range;
			//make sure $end doesn't go beyond total pages
			if($end > $this->total_pages){
				$end=$this->total_pages;
				//if there is a change in $end, adjust $start again
				$start= ($end - $range) > 0 ? ($end - $range) : 1;
			}
			$qstring=$_SERVER['QUERY_STRING'];
			$regex='|&?page=\d+|';
			$qstring=preg_replace($regex,"",$qstring);
			$separator=$qstring=='' ? '?' : '?'.$qstring.'&';

			if($b){	// SEO friendly paging with no question mark
				if($start>1){
					echo '<li><a href="page-1" class="pageNo">1</a></li>';
				}
				for($i=$start;$i<=$end;$i++){
					if($i==$this->current_page){
						// Current page is not clickable and different from other pages
						echo "<a class=\"disabledPageNo\">$i</a>";	
					} else {
						echo "<li><a href=\"page-$i\" class=\"pageNo\">$i</a></li>";
					}
				}
				if($end < $this->total_pages){
					// If $end is away from total pages, add a link of the last page
					echo "... <li><a href=\"page-{$this->total_pages}\" class=\"pageNo\">{$this->total_pages}</a></li>";	
				}
			} else{	// Paging with question mark
				if($start>1){
					echo '<li><a href="'.$separator.'page=1" class="pageNo">1</a></li>';
				}
				for($i=$start;$i<=$end;$i++){
					if($i==$this->current_page){
						// Current page is not clickable and different from other pages
						echo "<li class='active'><a class=\"disabledPageNo\">$i</a></li>";
					} else {
						echo "<li><a href=\"".$separator."page=$i\" class=\"pageNo\">$i</a></li>";
					}
				}
				if($end < $this->total_pages){
					// If $end is away from total pages, add a link of the last page
					echo "<li>... <a href=\"".$separator."page={$this->total_pages}\" class=\"pageNo\">{$this->total_pages}</a></li>";
				}
			}
			echo "</ul>";
		}
	}
?>