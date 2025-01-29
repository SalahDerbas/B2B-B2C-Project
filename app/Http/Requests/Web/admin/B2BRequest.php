<?php

namespace App\Http\Requests\Web\admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use App\Models\Operater;
use App\Models\Payment;
use Carbon\Carbon;

use Illuminate\Validation\Rule;


class B2BRequest extends FormRequest
{
    private const ROUTE_B2B_STORE              = 'admin.b2bs.store';
    private const ROUTE_B2B_UPDATE             = 'admin.b2bs.update';
    private const ROUTE_B2B_DELETE             = 'admin.b2bs.delete';
    private const ROUTE_B2B_EDIT               = 'admin.b2bs.edit';
    private const ROUTE_B2B_SWITCH_STATUS      = 'admin.b2bs.switchStatus';
    private const ROUTE_B2B_EDIT_OPERATERS     = 'admin.b2bs.editOperaters';
    private const ROUTE_B2B_NEW_OPERATERS      = 'admin.b2bs.newOperaters';
    private const ROUTE_B2B_ADD_OPERATERS      = 'admin.b2bs.addOperaters';
    private const ROUTE_B2B_GET_ITEMS          = 'admin.b2bs.getItems';


    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Handle the processing of operator data.
     *
     * @author Salah Derbas
     */
    protected function handleOperaterData()
    {
        $data = $this->all();

        $operaters  = $data['operaters'] ?? [];
        $values     = $data['values'] ?? [];
        $types      = $data['types'] ?? [];
        $username   = $data['username'] ?? null;

        $this->validateOperaterData($operaters, $values, $types);

        $paymentId = $this->createPayment($username);

        $this->createOperaters($operaters, $values, $types, $paymentId);

        $this->replace(array_merge($data, ['payment_id' => $paymentId]));
    }

    /**
     * Validate the operator data counts.
     *
     * @author Salah Derbas
     */
    private function validateOperaterData(array $operaters, array $values, array $types)
    {
        if (count($operaters) !== count($values) || count($values) !== count($types)) {
            throw ValidationException::withMessages([
                'operaters' => 'The counts of operaters, values, and types must be the same.',
            ]);
        }
    }

    /**
     * Create a new payment record and return its ID.
     *
     * @author Salah Derbas
     */
    private function createPayment(?string $username): int
    {
        return Payment::insertGetId([
            'name'        =>  $username,
            'is_b2b'      =>  true,
            'status'      =>  true,
            'created_at'  =>  Carbon::now(),
            'updated_at'  =>  Carbon::now(),
        ]);
    }

    /**
     * Create operator records associated with a payment.
     *
     * @author Salah Derbas
     */
    private function createOperaters(array $operaters, array $values, array $types, int $paymentId)
    {
        $operaterData = [];

        foreach ($operaters as $index => $name) {
            $operaterData[] = [
                'payment_id'   =>  $paymentId,
                'name'         =>  $name,
                'type_id'      =>  $types[$index],
                'value'        =>  $values[$index],
                'created_at'   =>  Carbon::now(),
                'updated_at'   =>  Carbon::now(),
            ];
        }

        Operater::insert($operaterData);
    }

    /**
     * Handle validation after the request is passed.
     *
     * @author Salah Derbas
     */
    protected function passedValidation(): void
    {
        $route = $this->route()->getName();
        if ($route === self::ROUTE_B2B_STORE)
            $this->handleOperaterData();
    }

    /**
     * Define the rules for storing a B2B request.
     *
     * @author Salah Derbas
     */
    private function storeb2bRequest()
    {
        return [
            'rules' => [
                'username'          =>  ['required', Rule::unique(User::getTableName(), "usrename")],
                'name'              =>  ['required'],
                'email'             =>  ['required', Rule::unique(User::getTableName(), "email"), 'email'],
                'password'          =>  ['required', 'min:6', 'max:12'],
                'b2b_balance'       =>  ['required'],
                'operaters'         =>  ['required', 'array'],
                'values'            =>  ['required', 'array'],
                'types'             =>  ['required', 'array'],
            ]
        ];
    }

    /**
     * Define the rules for editing a B2B request.
     *
     * @author Salah Derbas
     */
    private function editb2bRequest()
    {
        return [
            'rules' => [
                'id' => ['required', 'exists:users,id'],
            ]
        ];
    }

    /**
     * Define the rules for updating a B2B request.
     *
     * @author Salah Derbas
     */
    private function updateb2bRequest()
    {
        return [
            'rules' => [
                'id'                => ['required', 'exists:users,id'],
                'username'          => ['required', Rule::unique('users', 'usrename')->ignore($this->id)],
                'name'              => ['required'],
                'email'             => ['required', Rule::unique('users', 'email')->ignore($this->id)],
                'password'          => ['required', 'min:6', 'max:12'],
                'b2b_balance'       => ['required'],
            ]
        ];
    }

    /**
     * Define the rules for switching the status of a B2B request.
     *
     * @author Salah Derbas
     */
    private function switchStatusb2bRequest()
    {
        return [
            'rules' => [
                'id' => ['required', 'exists:users,id'],
            ]
        ];
    }

    /**
     * Define the rules for deleting a B2B request.
     *
     * @author Salah Derbas
     */
    private function deleteb2bRequest()
    {
        return [
            'rules' => [
                'id' => ['required', 'exists:users,id'],
            ]
        ];
    }

    /**
     * Define the rules for editing operators in a B2B request.
     *
     * @author Salah Derbas
     */
    private function editOperatersb2bRequest()
    {
        return [
            'rules' => [
                'id' => ['required', 'exists:users,id'],
            ]
        ];
    }

    /**
     * Define the rules for adding new operators in a B2B request.
     *
     * @author Salah Derbas
     */
    private function newOperatersb2bRequest()
    {
        return [
            'rules' => [
                'id' => ['required', 'exists:users,id'],
            ]
        ];
    }

    /**
     * Define the rules for adding operators to a B2B request.
     *
     * @author Salah Derbas
     */
    private function addOperatersb2bRequest()
    {
        return [
            'rules' => [
                'payment_id'        => ['required', 'exists:payments,id'],
                'name'              => ['required'],
                'value'             => ['required'],
                'type_id'           => ['required'],
            ]
        ];
    }

    /**
     * Define the rules for retrieving items in a B2B request.
     *
     * @author Salah Derbas
     */
    private function getItemsb2bRequest()
    {
        return [
            'rules' => [
                'id' => ['required', 'exists:users,id'],
            ]
        ];
    }    /**
     * Get requested data based on the current route.
     *
     * @param string $key
     * @return mixed
     * @author Salah Derbas
     */
    private function requested($key)
    {
        $route = $this->route()->getName();
        $data  = match ($route) {
            self::ROUTE_B2B_STORE                => $this->storeb2bRequest(),
            self::ROUTE_B2B_UPDATE               => $this->updateb2bRequest(),
            self::ROUTE_B2B_DELETE               => $this->deleteb2bRequest(),
            self::ROUTE_B2B_EDIT                 => $this->editb2bRequest(),
            self::ROUTE_B2B_SWITCH_STATUS        => $this->switchStatusb2bRequest(),
            self::ROUTE_B2B_EDIT_OPERATERS       => $this->editOperatersb2bRequest(),
            self::ROUTE_B2B_NEW_OPERATERS        => $this->newOperatersb2bRequest(),
            self::ROUTE_B2B_ADD_OPERATERS        => $this->addOperatersb2bRequest(),
            self::ROUTE_B2B_GET_ITEMS            => $this->getItemsb2bRequest(),

                default => [ 'rules' => [], 'messages' => []  ]
        };
        return $data[$key];

    }

    /**
     * Get the validation rules for the request.
     *
     * @return array
     * @author Salah Derbas
     */
    public function rules()
    {
        return $this->requested('rules');
    }
}
