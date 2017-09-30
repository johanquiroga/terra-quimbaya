<?php

namespace App;

trait Miscelaneous {

	/**
	 * Remove the given keys off data
	 *
	 * @param $data
	 * @param $keys
	 * @return array
	 */
	public function cleanArray($data, array $keys)
	{
		foreach ($data as &$item) {
			foreach ($keys as $key) {
				$args = explode('.', $key);
				$sub_item = &$item;
				$last = array_pop($args);
				foreach ($args as $arg) {
					if(!array_has($sub_item, $arg)) {
						return;
					}

					$sub_item = &$sub_item[$arg];
				}
				unset($sub_item[$last]);
			}
		}
		unset($item);
		return $data;
	}

	/**
	 * Append the given type on element position in data.
	 *
	 * @param $data
	 * @param $type
	 * @param $element
	 * @return mixed
	 */
	public function appendValue($data, $type, $element)
	{
		// operate on the item passed by reference, adding the element and type
		foreach ($data as $key => & $item) {
			$item[$element] = $type;
		}
		return $data;
	}

	/**
	 * Append the 'url' information in data.
	 *
	 * @param $data
	 * @param $prefix
	 * @return mixed
	 */
	public function appendURL($data, $prefix)
	{
		// operate on the item passed by reference, adding the url based on id
		foreach ($data as $key => & $item) {
			$item['url'] = route($prefix, $item[($item['class'] == 'product') ? 'idPublicacion' : 'id']);
		}
		return $data;
	}


}