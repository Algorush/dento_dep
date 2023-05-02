<?php

namespace App\CustomStyles;


use App\Services\ImagesPrepare;
use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Http\Request;
use Laracasts\Presenter\Exceptions\PresenterException;
use Webmagic\Core\Entity\Exceptions\EntityNotExtendsModelException;
use Webmagic\Core\Entity\Exceptions\ModelNotDefinedException;

class CustomStylingService
{
    /**
     * @var CustomStylingRepo
     */
    protected $stylingRepo;

    /**
     * CustomStylingService constructor.
     *
     * @param CustomStylingRepo $stylingRepo
     */
    public function __construct(CustomStylingRepo $stylingRepo)
    {
        $this->stylingRepo = $stylingRepo;
    }


    public function createCustomStylingForUser(Model $user, Request $request)
    {
        $this->stylingRepo->create([
            'primary_color' => $request->get('primary_color', null),
            'header_color' => $request->get('header_color', null),
            'body_color' => $request->get('body_color', null),
            'text_color' => $request->get('text_color', null),
            'background_color' => $request->get('background_color', null),
            'progressbar_color' => $request->get('progressbar_color', null),
            'progressbar_background_color' => $request->get('progressbar_background_color', null),
            'user_id' => $user->id
        ]);
    }

    public function updateCustomStylingForUser(Model $user, Request $request)
    {
        $customStyling = $this->stylingRepo->getByUserID($user->id);

        if(is_null($customStyling)){
            $this->createCustomStylingForUser($user, $request);
        } else{
            $this->stylingRepo->update($customStyling->id, [
                'primary_color' => $request->get('primary_color', null),
                'header_color' => $request->get('header_color', null),
                'body_color' => $request->get('body_color', null),
                'text_color' => $request->get('text_color', null),
                'background_color' => $request->get('background_color', null),
                'progressbar_color' => $request->get('progressbar_color', null),
                'progressbar_background_color' => $request->get('progressbar_background_color', null)
            ]);
        }
    }
}
