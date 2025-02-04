import { forwardRef, useEffect, useImperativeHandle, useRef } from 'react';

export default forwardRef(function SelectInput({
        name, id, value, className, required, isFocused, options, ...props}, ref) {

    const input = ref ? ref : useRef();
    // const localRef = useRef(null);
    // useImperativeHandle(ref, () => ({
    //     focus: () => localRef.current?.focus(),
    // }));

    useEffect(() => {
        if (isFocused) {
            input.current?.focus();
        }
    }, []);

    return (
        <div className="flex flex-col items-start">
            <select
                {...props}
                name={name}
                id={id}
                value={value}
                className={
                    `border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm ` +
                    className
                }
                ref={input}
                required={required}>
                    <option value="">Select Option</option>
                    {
                        options?.map((item, index) => {
                            return  <option key={index} value={item}>{item}</option>
                        })
                    }
            </select>
        </div>
    );
});
