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
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        name: '',
        day: '',
        seat: 0
    });

    const handleOnChange = (event) => {
        setData(event.target.name, event.target.value);
    };

    const submit = (e) => {
        e.preventDefault();
        post(route('init'));
    };

    const book = (seat) => {
        setSeat(seat);
        setOpen(true);
        setData('seat', seat);
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
                    <img src="/assets/images/seat.jpeg" class="rounded d-none d-md-block w-full h-[400px]" alt="" />
                    <h4 className="mb-4 mt-10 text-2xl font-bold text-gray-200 underline">Day {day} of the Event</h4>

                    <div className="md:flex gap-10 justify-between">
                        <div className="basis-2/5 mb-10 md:mb-0">
                            <h4 className="text-white text-center text-4xl font-bold mb-4">A</h4>
                            <div className="grid grid-cols-4 md:grid-cols-6 gap-3">
                                {
                                    seats?.slice(0, 12).map(item => {
                                        return <div class={"p-1 py-2 rounded shadow-sm text-center " + ([1,2,3,4,5,6,7,8,9,10,...booked].includes(item) ? ' bg-red-500 text-white' : ' bg-white cursor-pointer')}
                                        onClick={!booked.includes(item) ? () => book(item) : null}>
                                            <p class="mb-2 small">{[1,2,3,4,5,6,7,8,9,10,...booked].includes(item) ? 'Booked' : item}</p>
                                            <i class={"fa-solid fa-chair fa-2xl fa-rotate-180"}></i>
                                        </div>
                                    })
                                }
                            </div>
                        </div>

                        <div className="basis-2/5">
                            <h4 className="text-white text-center text-4xl font-bold mb-4">B</h4>
                            <div className="grid grid-cols-4 md:grid-cols-6 gap-3">
                                {
                                    seats?.slice(12, 24).map(item => {
                                        return <div class={"p-1 py-2 rounded shadow-sm text-center " + (booked.includes(item) ? ' bg-red-500 text-white' : ' bg-white cursor-pointer')}
                                        onClick={!booked.includes(item) ? () => book(item) : null}>
                                            <p class="mb-2 small">{booked.includes(item) ? 'Booked' : item}</p>
                                            <i class={"fa-solid fa-chair fa-2xl fa-rotate-180"}></i>
                                        </div>
                                    })
                                }
                            </div>
                        </div>
                    </div>

                    <div className="md:flex gap-3 mt-10 justify-between">
                        <div className="basis-2/5 mb-10 md:mb-0">
                            <h4 className="text-white text-center text-4xl font-bold mb-4">C</h4>
                            <div className="grid grid-cols-4 md:grid-cols-6 gap-3">
                                {
                                    seats?.slice(24, 36).map(item => {
                                        return <div class={"p-1 py-2 rounded shadow-sm text-center " + (booked.includes(item) ? ' bg-red-500 text-white' : ' bg-white cursor-pointer')}
                                        onClick={!booked.includes(item) ? () => book(item) : null}>
                                            <p class="mb-2 small">{booked.includes(item) ? 'Booked' : item}</p>
                                            <i class={"fa-solid fa-chair fa-2xl fa-rotate-180"}></i>
                                        </div>
                                    })
                                }
                            </div>
                        </div>

                        <div className="basis-2/5">
                            <h4 className="text-white text-center text-4xl font-bold mb-4">D</h4>
                            <div className="grid grid-cols-4 md:grid-cols-6 gap-3">
                                {
                                    seats?.slice(36, 48).map(item => {
                                        return <div class={"p-1 py-2 rounded shadow-sm text-center " + (booked.includes(item) ? ' bg-red-500 text-white' : ' bg-white cursor-pointer')}
                                        onClick={!booked.includes(item) ? () => book(item) : null}>
                                            <p class="mb-2 small">{booked.includes(item) ? 'Booked' : item}</p>
                                            <i class={"fa-solid fa-chair fa-2xl fa-rotate-180"}></i>
                                        </div>
                                    })
                                }
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    )
}

export default Seats;
