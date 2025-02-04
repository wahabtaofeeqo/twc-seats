import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import Modal from "@/Components/Modal";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import { Head, useForm } from "@inertiajs/react";
import { useEffect, useState } from "react"

const Seats = ({seats = [], booked = [], day}) => {

    const [seat, setSeat] = useState(0);
    const [isOpen, setOpen] = useState(false);
    const { data, setData, post, processing, errors } = useForm({
        day: '',
        name: '',
        email: '',
        seat_id: 0,
        color: 'blue',
        seat_number: 0
    });

    const handleOnChange = (event) => {
        setData(event.target.name, event.target.value);
    };

    const submit = (e) => {
        e.preventDefault();
        post(route('init'));
    };

    const book = (seat) => {
        setOpen(true);
        setSeat(seat.number);
        setData({
            ...data,
            seat_id: seat.id,
            seat_number: seat.number || 0
        });
    }

    const groupA = () => {
        let counter = 35;
        let elements = [];

        for (let index = 20; index < 41; index++) {
            let seat = {
                ...seats[index],
                number: counter
            }
            const element = <div class={"p-1 py-2 rounded shadow-sm text-center " + (booked.includes(seat.id) ? ' bg-red-500 text-white' : ' bg-white text-blue-400 cursor-pointer')}
            onClick={!booked.includes(seat.id) ? () => book(seat) : null}>
                <p class="mb-2 small">{booked.includes(seat.id) ? 'Booked' : counter}</p>
                <i class={"fa-solid fa-chair fa-2xl fa-rotate-180"}></i>
            </div>

            elements.push(element);

            counter--;
            if(counter % 7 == 0) counter -= 7;
        }

        return elements;
    }

    const groupB = () => {
        let counter = 42;
        let elements = [];

        for (let index = 41; index < 62; index++) {
            let seat = {
                ...seats[index],
                number: counter
            }

            const element = <div class={"p-1 py-2 rounded shadow-sm text-center " + (booked.includes(seat.id) ? ' bg-red-500 text-white' : ' bg-white text-blue-400 cursor-pointer')}
            onClick={!booked.includes(seat.id) ? () => book(seat) : null}>
                <p class="mb-2 small">{booked.includes(seat.id) ? 'Booked' : counter}</p>
                <i class={"fa-solid fa-chair fa-2xl fa-rotate-180"}></i>
            </div>

            elements.push(element);
            counter--;
            if(counter % 7 == 0) counter -= 7;
        }

        return elements;
    }

    const groupC = () => {
        let counter = 62;
        let elements = [];
        for (let index = 0; index < 20; index++) {
            let seat = {
                ...seats[index],
                color: 'white',
                number: counter
            }

            const element = <div class={"p-1 py-2 rounded shadow-sm text-center " + (booked.includes(seat.id) ? ' bg-red-500 text-white' : ' bg-gray-500 text-white cursor-pointer')}
            onClick={!booked.includes(seat.id) ? () => book(seat) : null}>
                <p class="mb-2 small">{booked.includes(seat.id) ? 'Booked' : counter}</p>
                <i class={"fa-solid fa-chair fa-2xl fa-rotate-180"}></i>
            </div>

            elements.push(element);
            counter--;
            // if(counter % 5 == 0) counter -= 5;
        }

        return elements;
    }

    useEffect(() => {
        if(day) setData('day', day);
    }, [day])

    return (
        <>
            <Head title="Seats"></Head>
            <Modal show={isOpen} onClose={() => setOpen(false)}>
                <div className="p-5">
                    <h4 className="text-2xl font-bold">Seat Number: {seat}</h4>
                    <p className="text-red-500 mb-5 text-sm">This is for members only. Payments are non-refundable</p>
                    <form onSubmit={submit}>
                        <div>
                            <InputLabel htmlFor="name" value="Name" />

                            <TextInput
                                id="name"
                                type="text"
                                name="name"
                                value={data.name}
                                className="mt-1 block w-full rounded-0"
                                onChange={handleOnChange}
                            />

                            <InputError message={errors.name} className="mt-2" />
                        </div>

                        <div className="mt-4">
                            <InputLabel htmlFor="email" value="Email" />

                            <TextInput
                                id="email"
                                type="email"
                                name="email"
                                value={data.email}
                                className="mt-1 block w-full"
                                onChange={handleOnChange}
                            />

                            <InputError message={errors.email} className="mt-2" />
                        </div>

                        <div className="flex items-center justify-end mt-8">
                            <PrimaryButton className="p-4" disabled={processing}>
                                Make Payment
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </Modal>

            <div className="min-h-screen bg-gradient-to-r from-cyan-500 to-blue-500 py-3">
                <div className="max-w-7xl mx-auto p-3">
                    <img src="/assets/images/seat.jpeg" className="rounded d-none d-md-block w-full h-[400px]" alt="" />
                    <h4 className="mb-4 mt-10 text-2xl font-bold text-gray-200 underline">Day {day} of the Event</h4>

                    <div className="md:flex justify-between">
                        <div className="basis-3/6 md:pe-10">
                            <h4 className="text-white text-center text-4xl font-bold mb-4">B</h4>
                            <div className="grid grid-cols-4 md:grid-cols-7 gap-1">
                               {groupB()}
                            </div>
                        </div>

                        <div className="basis-3/6 mb-10 md:mb-0 md:ps-10">
                            <h4 className="text-white text-center text-4xl font-bold mb-4">A</h4>
                            <div className="grid grid-cols-4 md:grid-cols-7 gap-1">
                                {groupA()}
                            </div>
                        </div>
                    </div>

                    <div className="md:flex mt-10 justify-end">
                        <div className="basis-2/4 mb-10 md:mb-0 md:ps-10">
                            <h4 className="text-white text-center text-4xl font-bold mb-4">C</h4>
                            <div className="grid grid-cols-4 md:grid-cols-5 gap-1">
                                {groupC()}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    )
}

export default Seats;
