import React, { useEffect, useState } from "react";
import { SafeAreaView, View, StyleSheet } from "react-native";
import QRCode from 'react-native-qrcode-svg';
import * as Brightness from 'expo-brightness';
import { fetchQR } from "../services/AuthServices";
import { useFocusEffect } from '@react-navigation/native';

export default function QRScreen() {
    const [qrValue, setQrValue] = useState(" ");
    const [previousBrightness, setPreviousBrightness] = useState(null);

    async function fetchQrData() {
        try {
            const qr = await fetchQR({});
            setQrValue(qr);
        } catch (e) {
            console.log(e);
        }
    }

    useFocusEffect(
        React.useCallback(() => {
            const adjustBrightness = async () => {
                const { status } = await Brightness.requestPermissionsAsync();
                if (status === 'granted') {
                    const currentBrightness = await Brightness.getSystemBrightnessAsync();
                    setPreviousBrightness(currentBrightness); 
                    await Brightness.setSystemBrightnessAsync(1);  
                } else {
                    console.log("Permission to change brightness was not granted.");
                }
            };

            adjustBrightness();
            fetchQrData();
            const interval = setInterval(fetchQrData, 120000); 

            return () => {
                if (previousBrightness !== null) {
                    Brightness.setSystemBrightnessAsync(previousBrightness); 
                }
                clearInterval(interval);
            };
        }, [previousBrightness])
    );

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
