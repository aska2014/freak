<?php namespace Kareem3d\Freak\Core;

abstract class ElementController extends Controller {

    /**
     * Show all the resources.
     *
     * @return mixed
     */
    public abstract function index();

    /**
     * Show details about the resource.
     *
     * @param $id
     * @return mixed
     */
    public abstract function show($id);

    /**
     * Insert new resource.
     *
     * @return mixed
     */
    public abstract function store();

    /**
     * Update an existing resource.
     *
     * @param $id
     * @return mixed
     */
    public abstract function update($id);

    /**
     * Delete a resource
     *
     * @param $id
     * @return mixed
     */
    public abstract function destroy($id);

    /**
     * Delete many resources
     *
     * @return mixed
     */
    public function deleteMany()
    {
        $boolean = false;

        foreach(Input::get('ids') as $id)
        {
            $boolean = $this->deleteIndex($id);
        }

        return $boolean;
    }
}