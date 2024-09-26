import React, { useContext, useEffect, useState } from "react";
import { SafeAreaView, Button, View, StyleSheet } from "react-native";
import { fetchQR } from "../services/AuthServices";
import QRCode from 'react-native-qrcode-svg';
import * as Brightness from 'expo-brightness';

export default function App() {
    const [qrValue, setQrValue] = useState(" ");

    useEffect(() => {
        (async () => {
            const { status } = await Brightness.requestPermissionsAsync();
            if (status === 'granted') {
                await Brightness.setSystemBrightnessAsync(1);
            } else {
                console.log("Permission to change brightness was not granted.");
            }
        })();
    }, []);

    async function fetchQrData() {
        try {
            const qr = await fetchQR({});
            setQrValue(qr);
            console.log("user", qr);
        } catch (e) {
            console.log(e);
        }
    }

    useEffect(() => {
        fetchQrData();

        const interval = setInterval(fetchQrData, 120000);

        return () => clearInterval(interval);
    }, []);

    

    return (
        <SafeAreaView style={styles.container}>
            <View style={styles.qrContainer}>
                <QRCode
                    value={qrValue}
                    size={200}
                />
            </View>
            
           
        </SafeAreaView>
    );
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        justifyContent: 'center',
        alignItems: 'center',
        backgroundColor: '#fff',
    },
    qrContainer: {
        marginBottom: 30,
    },
});
