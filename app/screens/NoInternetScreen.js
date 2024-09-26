import React, { useRef, useEffect } from 'react';
import { View, Text, StyleSheet, Animated, Easing } from 'react-native';

const NoInternetScreen = () => {
    const bounceAnim = useRef(new Animated.Value(0)).current;
    const opacityAnim = useRef(new Animated.Value(0)).current;

    useEffect(() => {
        Animated.loop(
            Animated.sequence([
                Animated.parallel([
                    Animated.timing(bounceAnim, {
                        toValue: 1,
                        duration: 1000,
                        easing: Easing.bounce,
                        useNativeDriver: true,
                    }),
                    Animated.timing(opacityAnim, {
                        toValue: 1,
                        duration: 1000,
                        useNativeDriver: true,
                    }),
                ]),
                Animated.parallel([
                    Animated.timing(bounceAnim, {
                        toValue: 0,
                        duration: 1000,
                        easing: Easing.bounce,
                        useNativeDriver: true,
                    }),
                    Animated.timing(opacityAnim, {
                        toValue: 0,
                        duration: 1000,
                        useNativeDriver: true,
                    }),
                ]),
            ])
        ).start();
    }, [bounceAnim, opacityAnim]);

    const bounce = bounceAnim.interpolate({
        inputRange: [0, 1],
        outputRange: [0, -20],
    });

    return (
        <View style={styles.container}>
            <Animated.Text
                style={[
                    styles.message,
                    {
                        transform: [{ translateY: bounce }],
                        opacity: opacityAnim,
                    },
                ]}
            >
                No Internet Connection
            </Animated.Text>
        </View>
    );
};

const styles = StyleSheet.create({
    container: {
        flex: 1,
        justifyContent: 'center',
        alignItems: 'center',
        backgroundColor: '#f8f8f8',
    },
    message: {
        fontSize: 22,
        color: '#ff4d4d',
        fontWeight: 'bold',
    },
});

export default NoInternetScreen;
