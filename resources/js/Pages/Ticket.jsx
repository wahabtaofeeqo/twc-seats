import CheckoutForm from "@/Components/CheckoutForm";
import { Head, Link, useForm } from "@inertiajs/react";
import moment from "moment";
import { useEffect, useState } from "react";
import { ToastContainer, toast } from "react-toastify";


const Ticket = ({categories = [], bookings = [], days = []}) => {

    const [tickets, setTickets] = useState([]);
    const [isCheckout, setCheckout] = useState(false);
    const [invitees, setInvitees] = useState([]);

    const { data, setData, post, processing, errors, reset } = useForm({
        firstname: '',
        lastname: '',
        email: '',
        phone: '',
        name: '',
        day: 0,
        quantity: 1,
        // Not needed for this type of booking though
        seat_id: 0,
        color: 'blue',
        seat_number: 0,
        tickets: [],
        amount: 0,
        coupon: '',
        invitees: []
    });

    const incrementTicket = (id) => {
        let allTickets = [...tickets];
        let index = allTickets.findIndex(item => item.model.id == id);
        let ticket = tickets[index];

        // Check if a Ticket type is currently selected
        let current = allTickets.find(item => item.total > 0);
        if(current && current.model.id != ticket.model.id) {
            toast.warn(`You can only book a single Ticket Type at a Time`);
        }
        else {
            ticket.total = ticket.total + 1;
            allTickets[index] = ticket;

            //
            setTickets(allTickets);
            setData('tickets', allTickets);
        }
    }

    const decrementTicket = (id) => {

        let allTickets = [...tickets];
        let index = allTickets.findIndex(item => item.model.id == id);
        let ticket = tickets[index];

        if(ticket.total > 0) {
            ticket.total = ticket.total - 1;
            allTickets[index] = ticket;

            //
            setTickets(allTickets);
            setData('tickets', allTickets);
        }
    }

    const getTicket = (category) => {
        let allTickets = [...tickets];
        let ticket = allTickets.find(item => item.model.id == category.id);
        if(!ticket) { // Add Ticket
            ticket = {
                total: 0, // Initial
                model: category
            }

            allTickets.push(ticket);
            setTickets(allTickets);
        }

        return ticket;
    }

    const onChange = (event) => {
        setData(event.target.name, event.target.value);
    }

    const onContinue = () => {
        if(getTicketCount() == 0) {
            toast.warn('You need to select a Ticket to book');
            return;
        }

        if(data.day == 0) {
            toast.warn('You need to select a Day');
            return;
        }

        setCheckout(true);
    }

    const addInvitee = () => {

        let totalTicket = getTicketCount();
        if(totalTicket - 1 <= invitees.length) {
            toast.error('You need to select Ticket for the Invitees');
            return;
        }

        let all = [...invitees];
        all.push({ name: '', email: ''})

        setInvitees(all);
        setData('invitees', all)
    }

    const updateInvitee = (index, item) => {
        let all = [...invitees];
        all[index] = item;
        setInvitees(all);
        setData('invitees', all)
    }

    const getTotal = () => {
        let total = 0;
        tickets.forEach(item => {
            total += item.total * item.model.amount;
        });

        return total;
    }

    const getTicketCount = () => {
        let totalTicket = 0;
        tickets.forEach(item => totalTicket += item.total);
        return totalTicket ?? 0;
    }

    const validateEmail = (mail) => {
        let pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/
        return pattern.test(mail);
    }

    const submit = (e) => {
        e.preventDefault();

        let isValid = true;
        for (let i = 0; i < invitees.length; i++) {
            let item = invitees[i];
            isValid = (item.name && validateEmail(item.email));
            if(!isValid) break;
        }

        // let totalTicket = getTicketCount() - 1;
        // if(totalTicket != invitees.length) {
        //     toast.error('Users and Tickets selected must be equal');
        //     return;
        // }

        if(!isValid) {
            toast.error('Kindly provide your invitees details!');
            return;
        }

        post(`/bookings`, {
            onSuccess: () => {
                reset();
                // onCreated(true)
            },
            onError: (error) => {
                console.log(error);
                // setMessage(error?.message)
            }
        })
    }

    const isSoldOut = (model) => {
        // let obj: any = bookings.find((item: any) => item.id == model.id);
        // let max = model.name.toLowerCase() == 'vip' ? 100 : 200;
        // return (obj?.total || 0) >= max
        // return model.name.toLowerCase() == 'vip';
        return model.is_sold ?? false;
    }

    const format = (date) => {
        return moment(date).format("MMM Do");
    }

    const setDay = (model) => {
        setData('day', model.day);
    }

    useEffect(() => {
        if(tickets.length || data.firstname || data.lastname) {
            setData({
                ...data,
                amount: getTotal(),
                quantity: getTicketCount(),
                name: data.firstname + ' ' + data.lastname
            });
        }
    }, [tickets, data.firstname, data.lastname]);

    return (
        <>

        <Head title={`Tickets`} />
        <ToastContainer limit={1} />

        <div className="min-h-screen bg-sky-700">
            <div className='max-w-7xl mx-auto'>
                {/* <nav className="px-3 mb-10 py-5 inline-flex">
                    <Link href="/" className="flex items-center font-bold text-xl text-red-400">
                        Ushbebe
                    </Link>
                </nav> */}

                <header className='mb-5'>
                    <h1 className='text-4xl font-bold title text-center py-5' style={{color: '#E7EAEE'}}>
                        {
                            isCheckout ? 'CHECKOUT' : 'YOUR TICKET'
                        }
                    </h1>
                </header>

                {
                    isCheckout ?
                    (
                        <div className="px-3">
                            <form onSubmit={submit}>
                                <CheckoutForm data={data} onChange={onChange} onAdd={addInvitee}
                                    onUpdated={updateInvitee} invitees={invitees}></CheckoutForm>

                                <div className='py-4 text-end flex gap-3 justify-end'>
                                    <button type='button' disabled={processing} className='bg-gray-100 p-2 px-3 rounded' onClick={() => setCheckout(false)}>Cancel</button>
                                    <button disabled={processing} className='bg-sky-500 text-white p-2 px-3 rounded w-48'>Pay now</button>
                                </div>
                            </form>

                        </div>
                    )
                    :
                    (
                        <div className="p-3">
                            <div className="mb-4">
                                <p className="mb-4 text-lg text-white font-bold">Select a Day to proceed</p>
                                <div className="grid grid-cols-5 md:grid-cols-10 gap-3">
                                    {
                                        days.map(item => {
                                            return <button onClick={() => setDay(item)} className={"bg-white h-10 cursor-pointer shadow-sm rounded font-bold text-sm text-blue-500 flex items-center justify-center" + (data.day == item.day ? ' border-2 border-red-500' : '')}>
                                                {format(item.event_date)}
                                            </button>
                                        })
                                    }
                                </div>
                            </div>

                            {
                                categories.map((item, index) => {
                                    return (
                                        <div className="md:flex rounded border mb-10 gap-3 border-red-400" key={index}>
                                            <div className="basis-3/5 p-3">
                                                <img src="/assets/images/banner25.jpg" alt="regular" className="rounded lg:h-64 w-full" />
                                            </div>
                                            <div className="basis-2/5 p-3 flex flex-col items-between justify-between">
                                                <div className="mb-6">
                                                    <p className='font-bold mb-4 text-xl'>
                                                        {getTicket(item)?.total} x {item.name}
                                                    </p>

                                                    <div className="flex justify-between items-center">
                                                        <p className="">Sub Total</p>
                                                        <p className='p-1 px-2 rounded bg-white'>
                                                            NGN {getTicket(item)?.total * item.amount}
                                                        </p>
                                                    </div>
                                                </div>

                                                {
                                                    !isSoldOut(item) ? (
                                                        <div className="rounded flex justify-end items-center text-end cursor-pointer">
                                                            <i className="fa-solid fa-minus block border bg-white border-e-0 p-1 px-5 rounded-s" onClick={() => decrementTicket(item.id)}></i>
                                                            <i className="fas fa-plus block border bg-white p-1 px-5 rounded-e" onClick={() => incrementTicket(item.id)}></i>
                                                        </div>
                                                    ) :
                                                    <div className="inline-block py-2 px-5 border rounded bg-red-500 text-white text-center">Sold out</div>
                                                }

                                            </div>
                                        </div>
                                    )
                                })
                            }
                        </div>
                    )
                }
                <div className='pb-4 text-end px-3'>
                    {
                        isCheckout
                        ? <div></div>
                        : <button type='button' className='bg-sky-500 text-white p-2 px-3 rounded w-48' onClick={onContinue}>Continue</button>
                    }
                </div>
            </div>
        </div>
        </>
    )
}

export default Ticket;
