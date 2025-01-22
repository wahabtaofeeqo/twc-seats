import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import moment from 'moment';
import PageLink from '@/Components/PageLink';
import { useState } from 'react';
import Modal from '@/Components/Modal';
// import CreateUserForm from '@/Components/CreateUserForm';

export default function Tickets({ auth, models, stats = [] }) {

    const [isOpen, setOpen] = useState(false);

    const getDate = (model) => {
        return moment(model.created_at).format('MMMM Do YYYY');
    }

    const getTotalTickets = (model) => {
        let total = model.quantity || 0;
        if(model.booker.is_buyer) {
            model.booker.tickets.forEach(item => total += item.total);
        }
        else total = 1;

        return total;
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
                    {/* <CreateUserForm onCreated={() => setOpen(false)}></CreateUserForm> */}
                </div>
            </Modal>

            <div className="py-12">
                <div className="max-w-7xl mx-auto px-4">

                    <div className='lg:flex gap-3'>
                       {
                        stats?.map((item, index) => {
                            return (
                                <div key={index} className='text-gray-900 mx-4 h-44 lg:mx-0 bg-white p-3 basis-2/5 shadow-sm rounded mb-4'>
                                    <h1 className='font-bold mb-4'>{item.name}</h1>
                                    <div className='flex gap-3 items-center'>
                                        <i className="fas fa-ticket fa-3x text-sky-500"></i>
                                        <p className='text-2xl'>{item.total}</p>
                                    </div>
                                </div>
                            )
                        })
                       }
                    </div>

                    <div className="bg-white overflow-hidden shadow-sm lg:mx-0 rounded mb-6">
                        <div className='text-end p-3 py-4'>
                            <a href="/dashboard/export-qr" className="bg-sky-900 rounded ms-6 px-3 py-2 text-white text-xs">Export Data</a>
                            {/* <button className='bg-red-500 text-white py-2 px-5 rounded' onClick={() => setOpen(!isOpen)}>Add User</button> */}
                        </div>
                        <div className="relative overflow-x-auto">
                            <table className="w-full text-sm text-left text-gray-500">
                                <thead className="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" className="px-6 py-3">#</th>
                                        <th scope="col" className="px-6 py-3">Name</th>
                                        <th scope="col" className="px-6 py-3">Email</th>
                                        {/* <th scope="col" className="px-6 py-3">Phone</th> */}
                                        <th scope="col" className="px-6 py-3">Type</th>
                                        <th scope="col" className="px-6 py-3">Buyer</th>
                                        <th scope="col" className="px-6 py-3">Total</th>
                                        <th scope="col" className="px-6 py-3">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {
                                        models.data.map((model, index) => {
                                            return (
                                                <tr className="bg-white border-b" key={index}>
                                                    <td className="px-6 py-4"> {index + 1} </td>
                                                    <td className="px-6 py-4 font-bold"> {model.booker.name} </td>
                                                    <td className="px-6 py-4"> {model.booker.email} </td>
                                                    <td className="px-6 py-4"> {model.category?.name || 'NA'} </td>
                                                    <td className="px-6 py-4"> {model.booker.is_buyer ? 'YES' : 'NO'} </td>
                                                    <td className="px-6 py-4"> {getTotalTickets(model)}</td>
                                                    <td className="px-6 py-4"> {getDate(model) || 'N/A'} </td>
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
