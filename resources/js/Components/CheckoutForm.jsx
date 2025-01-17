import { useState } from "react";
import InputLabel from "./InputLabel";
import TextInput from "./TextInput";

const CheckoutForm = ({data, onChange, onAdd, onUpdated, invitees = []}) => {

    const [isOpen, setOpen] = useState(false);
    const update = (index, e) => {
        let item = invitees[index];
        item[e.target.name] = e.target.value;
        onUpdated(index, item);
    }

    return (
        <>
        <div className='mb-10'>
            <h4 className="font-bold p-2 text-white">Personal Information</h4>
            <hr />
            <p className="text-gray-400 p-2">Please complete checkout to secure your ticket.</p>
        </div>

        <div>
            <div className="md:flex mb-4">
                <div className="basis-2/4 mb-4 pe-3">
                    <InputLabel htmlFor="firstname" className="font-bold text-gray-900" value="Firstname" />

                    <TextInput
                        id="firstname"
                        name="firstname"
                        value={data.firstname}
                        autoComplete="firstname"
                        onChange={onChange}
                        className="w-full rounded-2xl outline-none border-gray-200"
                        required
                    />
                </div>

                <div className="basis-2/4 pe-3 md:pe-0">
                    <InputLabel htmlFor="lastname" className="font-bold text-gray-900" value="Lastname" />

                    <TextInput
                        id="lastname"
                        name="lastname"
                        value={data.lastname}
                        autoComplete="lastname"
                        onChange={onChange}
                        className="w-full rounded-2xl outline-none border-gray-200"
                        required
                    />
                </div>
            </div>

            <div className="md:flex mb-4">
                <div className="basis-2/4 mb-4 pe-3">
                    <InputLabel htmlFor="email" className="font-bold text-gray-900" value="Email" />
                    <TextInput
                        id="email"
                        name="email"
                        value={data.email}
                        autoComplete="email"
                        type="email"
                        onChange={onChange}
                        className="w-full rounded-2xl outline-none border-gray-200"
                        required
                    />
                </div>

                <div className="basis-2/4 pe-3 md:pe-0">
                    <InputLabel htmlFor="phone" className="font-bold text-gray-900" value="Phone Number" />
                    <TextInput
                        id="phone"
                        name="phone"
                        value={data.phone}
                        autoComplete="phone"
                        onChange={onChange}
                        className="w-full rounded-2xl outline-none border-gray-200"
                        required
                    />
                </div>
            </div>

            {/* Invitees */}
            {/* <div className="flex justify-between items-center mb-4">
                <p className="caption">Invitees' Information</p>
                <div onClick={() => setOpen(!isOpen)} className="cursor-pointer">
                    {
                        isOpen ? <i className="fa-solid fa-arrow-up"></i> : <i className="fa-solid fa-arrow-down"></i>
                    }
                </div>
            </div> */}

            {
                isOpen ?
                <div className="text-center py-3 text-sky-600">
                    <i className="fa-solid fa-circle-plus cursor-pointer" onClick={onAdd}></i>
                </div> : ''
            }

            {
                invitees.map((item, index) => {
                    return (
                        <>
                            <div className="md:flex mb-4" key={index}>
                                <div className="basis-2/4 mb-4 pe-3">
                                    <InputLabel htmlFor="Name" className="font-bold" value="Name" />
                                    <TextInput
                                        id={`invitee-name-${index + 1}`}
                                        name="name"
                                        value={item.name}
                                        onChange={(e) => update(index, e)}
                                        className="w-full rounded-2xl outline-none border-gray-200"
                                        required
                                    />
                                </div>

                                <div className="basis-2/4 pe-3 md:pe-0">
                                    <InputLabel htmlFor="Email" className="font-bold" value="Email" />

                                    <TextInput
                                        id={`invitee-email-${index + 1}`}
                                        name="email"
                                        value={item.email}
                                        onChange={(e) => update(index, e)}
                                        className="w-full rounded-2xl outline-none border-gray-200"
                                        required
                                    />
                                </div>
                            </div>
                        </>
                    )
                })
            }
        </div>
        </>
    )
}

export default CheckoutForm;
