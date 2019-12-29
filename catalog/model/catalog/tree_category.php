<?php
class ModelCatalogTreeCategory extends Model {
	public function getTreeCategory() {
		$query = $this->db->query(
			"SELECT DISTINCT * FROM " . DB_PREFIX . "category c 
			LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) 
			LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) 
			WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
			AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' 
			AND c.status = '1'");

		$cats = [];
		foreach ($query->rows as $row) {
			$cats[$row['category_id']] = $row;
		}

		return $cats;
	}

    public function getMapTree($dataset) {
        $tree = array();

        foreach ($dataset as $id=>&$node) {
            if (!$node['parent_id']){
                $tree[$id] = &$node;
            }else{
                $dataset[$node['parent_id']]['childs'][$id] = &$node;
            }
        }

        return $tree;
	}
}

.clothes-trand-image-woman
	img
		display: inline-block
		height: auto
		max-width: 100%
		margin-right: auto


.image-sub
	display: flex
	position: absolute
	top: 40%
	width: 90%
	text-align: center
	.clothes-trand-text
		margin-left: auto
		margin-right: auto
		justify-content: space-between
		color: #fff	
		font:
			family: 'Montserrat', sans-serif
		h3
			font:
				size: 3.5rem
				weight: 800
				style: italic
		p 
			font:
				size: 1.8rem
				weight: 600