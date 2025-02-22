import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';
import moment from 'moment';
import PageLink from '@/Components/PageLink';
import { useState } from 'react';
import Modal from '@/Components/Modal';
import CreateBookingForm from '@/Components/CreateBookingForm';

export default function Dashboard({auth, models, stats = [], seats = [] }) {

    const [model, setModel] = useState(null);
    const [isOpen, setOpen] = useState(false);

    const setState = (model) => {
        setOpen(true)
        setModel(model);
        // return moment(model.created_at).format('MMMM Do YYYY');
    }

    const getDate = (model) => {
        return moment(model.created_at).format('MMMM Do YYYY');
    }

    return (
        <AuthenticatedLayout auth={auth}>
            <Head title="Dashboard" />

            <Modal show={isOpen} onClose={() => setOpen(false)}>
                <div className='p-4'>
                    <h1 className='font-bold text-xl'>Create Booking</h1>
                    <p className='mb-6 text-slate-500 text-sm'>
                        Create User Profile and Booking to send QR to.
                    </p>
                    <CreateBookingForm onCreated={() => setOpen(false)}
                        model={model} seats={seats}></CreateBookingForm>
                </div>
            </Modal>

            <div className="py-12">
                <div className="max-w-7xl mx-auto">

                    <div className='lg:flex lg:-mx-2'>

                       {
                        stats?.map((item, index) => {
                            return (
                               <div className='basis-1/4 px-2'>
                                 <div key={index} className='text-gray-900 p-4 h-44 bg-white shadow-sm rounded-md mb-4'>
                                    <h1 className='font-bold mb-4'>{item.name}</h1>
                                    <div className='flex gap-3 items-center'>
                                        <i className="fas fa-ticket fa-3x text-sky-500"></i>
                                        <p className='text-2xl'>{item.total}</p>
                                    </div>
                                </div>
                               </div>
                            )
                        })
                       }
                    </div>

                    <div className="bg-white overflow-hidden shadow-sm mx-4 lg:mx-0 rounded mb-6">
                        <div className='text-end p-3'>
                            <a href="/dashboard/export-qr" className="bg-sky-900 text-sm rounded ms-6 px-3 py-2 text-white me-3">Export Data</a>
                            <button className='bg-red-500 text-white py-2 px-5 rounded hidden' onClick={() => setOpen(!isOpen)}>Add User</button>
                        </div>

                        <div className="relative overflow-x-auto">
                            <table className="w-full text-sm text-left text-gray-500">
                                <thead className="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" className="px-6 py-3">#</th>
                                        <th scope="col" className="px-6 py-3">Name</th>
                                        <th scope="col" className="px-6 py-3">Email</th>
                                        <th scope="col" className="px-6 py-3">Day</th>
                                        <th scope="col" className="px-6 py-3">Type</th>
                                        <th scope="col" className="px-6 py-3">Number</th>
                                        <th scope="col" className="px-6 py-3">Date</th>
                                        <th scope="col" className="px-6 py-3">Status</th>
                                        <th scope="col" className="px-6 py-3">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {
                                        models.data.map((model, index) => {
                                            return (
                                                <tr className="bg-white border-b" key={index}>
                                                    <td className="px-6 py-4"> {index + 1} </td>
                                                    <td className="px-6 py-4 font-bold"> {model?.user?.name} </td>
                                                    <td className="px-6 py-4"> {model.user.email} </td>
                                                    <td className="px-6 py-4">
                                                        { model.event_date ? model.event_date : model.day}
                                                    </td>
                                                    <td className="px-6 py-4">
                                                        {
                                                            model.type == 'couch' ? <i class="fa-solid fa-couch"></i> :  <i class="fa-solid fa-chair"></i>
                                                        }
                                                    </td>
                                                    <td className="px-6 py-4"> {model.seat_number ?? 'NA'} </td>
                                                    <td className="px-6 py-4"> {getDate(model)} </td>
                                                    <td>
                                                        {model.confirmed ? 'Confirmed' : 'Pending'}
                                                    </td>
                                                    <td>
                                                        <Link href={'/dashboard/acceptance/' + model.id + '/accept'} className='p-1 bg-gray-100 rounded me-2'>
                                                            <i className='fas fa-check'></i>
                                                        </Link>
                                                        <Link href={'/dashboard/acceptance/' + model.id + '/reject'} className='p-1 bg-gray-100 rounded me-2 text-red-500'>
                                                            <i className='fas fa-x'></i>
                                                        </Link>
                                                        <button class="bg-gray-100 p-1 rounded hidden" onClick={() => setState(model)}>
                                                            <i className='fas fa-pencil'></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            )
                                        })
                                    }

                                    {
                                        models.data.length == 0 && (<tr>
                                            <td className='text-center pt-5' colSpan={8}>No Records Found</td>
                                        </tr>)
                                    }
                                </tbody>
                            </table>
                        </div>

                        <div className='px-6 py-3'>
                            <PageLink links={models.links}></PageLink>
                        </div>
                    </div>
                </div>
            </div>

        </AuthenticatedLayout>
    );
}
