import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { useForm } from '@inertiajs/react';
import { useEffect } from 'react';
import SelectInput from './SelectInput';

export default function CreateBookingForm({onCreated, model, seats = []}) {

    const { data, setData, post, put, processing, errors, reset } = useForm({
        name: '',
        email: '',
        seat_id: 0,
        seat_number: 0
    });

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value);
    };

    const submit = (e) => {
        e.preventDefault();

        const option = {
            onSuccess: () => {
                reset();
                onCreated(true)
            }
        }

        put(route('bookeds.update'), option)
    };

    const setSeat = (model, seat_number) => {
        setData({
            ...data,
            seat_number,
            'seat_id': model.id,
        });
    }

    useEffect(() => {
        if(model) {
            setData({
                ...data,
                id: model.id,
                name: model.user.name,
                email: model.user.email,
                seat_id: model.seat_id,
                seat_number: model.seat_number
            })
        }
    }, [model]);

    return (
            <form onSubmit={submit}>

                <div className='mt-4'>
                    <InputLabel htmlFor="lastname" value="Name" />

                    <TextInput
                        id="lastname"
                        name="lastname"
                        defaultValue={data.name}
                        className="mt-1 block w-full"
                        autoComplete="name"
                        onChange={onHandleChange}
                        required
                    />

                    <InputError message={errors.name} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        name="email"
                        defaultValue={data.email}
                        className="mt-1 block w-full"
                        autoComplete="username"
                        onChange={onHandleChange}
                        required
                    />

                    <InputError message={errors.email} className="mt-2" />
                </div>

                <div className="mt-4">
                    <h2>Seat Number</h2>
                    <SelectInput
                        id="seat_number"
                        name="seat_number"
                        value={data.seat_number}
                        className="mt-1 block w-full"
                        onChange={onHandleChange}
                        options={seats.map(item => item.id)}
                        required
                    />
                    {/* <div className="grid grid-cols-5 md:grid-cols-10 gap-3">
                        {
                            seats.map((item, index) => {
                                return <button onClick={() => setSeat(item, index + 1)} type='button' className={"bg-white h-10 cursor-pointer shadow-sm rounded font-bold text-sm text-blue-500 flex items-center justify-center" + (data.seat_number == (index + 1) ? ' border-2 border-red-500' : '')}>
                                    {index + 1}
                                </button>
                            })
                        }
                    </div> */}
                </div>

                <div className="flex items-center justify-end mt-6">
                    <PrimaryButton className="ml-4 bg-sky-500 px-5" disabled={processing}>Update</PrimaryButton>
                </div>
            </form>
    );
}
