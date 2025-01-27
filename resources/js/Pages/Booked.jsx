import { Head, Link } from '@inertiajs/react';
import axios from 'axios';
import { useEffect, useState } from 'react';

export default function Book(props) {

    let [status, setStatus] = useState(null);
    let [isProcessing, setProcessing] = useState(false);
    let [message, setMessage] = useState('Not verified');
    let ref = (new URLSearchParams(location.search)).get('reference');

    const verifyPayment = () => {
        setProcessing(true)
        setMessage('Verification in progress')
        axios.get(`/api/payments/verify/${ref}`)
            .then(response => {
                setStatus('success');
                setProcessing(false);
                setMessage('Payment verified successfully');
            })
            .catch(e => {
                setStatus('failed');
                setProcessing(false)
                setMessage(e.response?.data?.message || 'Verification failed');
            })
    }

    useEffect(() => {
       if(ref) verifyPayment();
    }, [ref])

    return (
        <>
            <Head title="Booking Verification" />
            <div className='max-w-7xl mx-auto'>
                <nav className="px-3 mb-10 py-5 hidden">
                    <Link href="/" className="flex items-center font-bold text-xl text-red-400">
                        Warri Again?
                    </Link>
                </nav>

                <header className='mt-5 mb-10'>
                    <h1 className='text-4xl font-bold title text-center' style={{color: '#E7EAEE'}}>
                        {
                            isProcessing ? 'Verifying...' :
                                status == 'success' ? 'Verified' : 'Failed'
                        }
                    </h1>
                </header>

                <div className='mb-4 px-3'>
                    <div className='md:w-1/4 rounded mx-auto flex justify-center items-end p-3 py-5' style={{height: '350px'}}>
                        {
                            isProcessing
                            ? <i className='fas fa-spinner ms-4 fa-spin'></i>
                            :
                            <div className='flex flex-col justify-end items-center'>

                                {
                                    status == 'success' ? <div></div> :
                                    <svg xmlns="http://www.w3.org/2000/svg" width="160" height="160" viewBox="0 0 160 160" fill="none">
                                        <path d="M61.8688 51.4644C59.9162 49.5118 56.7503 49.5118 54.7977 51.4644C52.8451 53.4171 52.8451 56.5829 54.7977 58.5355L72.9289 76.6666L54.7977 94.7978C52.8451 96.7504 52.8451 99.9162 54.7977 101.869C56.7503 103.821 59.9162 103.821 61.8688 101.869L79.9999 83.7377L98.1311 101.869C100.084 103.821 103.249 103.821 105.202 101.869C107.155 99.9162 107.155 96.7504 105.202 94.7978L87.071 76.6666L105.202 58.5355C107.155 56.5829 107.155 53.4171 105.202 51.4644C103.249 49.5118 100.084 49.5118 98.1311 51.4644L79.9999 69.5956L61.8688 51.4644Z" fill="#A70505"/>
                                        <path fillRule="evenodd" clipRule="evenodd" d="M83.5991 4.24418C81.2596 3.48542 78.7402 3.48542 76.4007 4.24418L21.4007 22.082C16.5964 23.6402 13.3333 28.1103 13.3333 33.1728V66.6666C13.3333 107.929 38.4719 138.033 76.0066 152.195C78.5776 153.166 81.4223 153.166 83.9933 152.195C121.528 138.033 146.667 107.929 146.667 66.6666V33.1747C146.667 28.1138 143.405 23.6407 138.599 22.082L83.5991 4.24418ZM79.4857 13.7564C79.82 13.648 80.1799 13.648 80.5141 13.7564L135.514 31.5942C136.205 31.8184 136.667 32.4567 136.667 33.1747V66.6666C136.667 103.076 114.795 129.885 80.463 142.839C80.1672 142.951 79.8326 142.951 79.5369 142.839C45.2049 129.885 23.3333 103.076 23.3333 66.6666L23.3333 33.1729C23.3333 32.4564 23.7929 31.8189 24.4857 31.5942L79.4857 13.7564Z" fill="#A70505"/>
                                    </svg>
                                }

                                <h4 className='font-bold text-2xl my-3'>
                                    {
                                        status == 'success' ? 'Payment Successful!' : 'Oops!'
                                    }
                                </h4>

                                <p className='mb-5 text-muted'>
                                    {
                                        status == 'success' ? 'Congrats, You can now enjoy the event.' : message
                                    }
                                </p>

                                {
                                    status == 'success' ?
                                    <a href='/' className='bg-yellow-500 p-2 px-3 rounded text-white'>Back to Home</a> :
                                    <button className='bg-red-700 p-2 px-5 text-white rounded' onClick={verifyPayment}>Try again</button>
                                }
                            </div>
                        }
                    </div>
                </div>
            </div>
        </>
    );
}
