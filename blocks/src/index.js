import { decodeEntities } from '@wordpress/html-entities';
import React from "react";
const { registerPaymentMethod } = window.wc.wcBlocksRegistry
const { getSetting } = window.wc.wcSettings

const settings = getSetting( 'other_payment_data', {} )
const label = decodeEntities( settings.title )

function Content(props) {
    const [paymentData, setPaymentData] = React.useState({})

    const { eventRegistration, emitResponse } = props;
    const { onPaymentProcessing } = eventRegistration;

    React.useEffect( () => {
        const unsubscribe = onPaymentProcessing( async () => {
            // Here we can do any processing we need, and then emit a response.
            // For example, we might validate a custom field, or perform an AJAX request, and then emit a response indicating it is valid or not.
            const myGatewayCustomData = '12345';
            const customDataIsValid = !! myGatewayCustomData.length;

            if ( customDataIsValid ) {
                return {
                    type: emitResponse.responseTypes.SUCCESS,
                    meta: {
                        paymentMethodData: {
                            ... paymentData,
                        },
                    },
                };
            }

            return {
                type: emitResponse.responseTypes.ERROR,
                message: 'There was an error',
            };
        } );
        // Unsubscribes when this component is unmounted.
        return () => {
            unsubscribe();
        };
    }, [
        emitResponse.responseTypes.ERROR,
        emitResponse.responseTypes.SUCCESS,
        onPaymentProcessing,
        paymentData
    ] );

    return <>
        <Textarea props={{setPaymentData, paymentData}} />
    </>
}
const Textarea = (attr) => {
    const isRequired = settings.is_required === 'yes'
    const hideTextBox = settings.hide_text_box === 'yes'
    function setContent(e) {
        const key = 'other_payment-admin-note'
        attr.props.paymentData[key] = e.target.value
        attr.props.setPaymentData(attr.props.paymentData)
    }
    return <>

            <p style={{'margin-bottom': 0, 'margin-top': 0}}><small
                style={{color: '#9ca3af'}}>{settings.description}</small></p>
        {!hideTextBox ? (
        <textarea style={{'margin': '5px 0 5px 0'}} className={'wc-block-components-textarea'}
                  id={'other_payment-admin-note'} name={'other_payment-admin-note'}
                  required={isRequired}
                  onInput={setContent} rows="2"
                  spellCheck="false"></textarea>
        ): (<></>)}

    </>
}
const Label = (props) => {
    const {PaymentMethodLabel} = props.components
    return <PaymentMethodLabel text={label}/>
}


registerPaymentMethod({
    name: "other_payment",
    label: <Label/>,
    content: <Content />,
    edit: <Content />,
    canMakePayment: () => true,
    ariaLabel: label,
    supports: {
        features: settings.supports,
    }
} )