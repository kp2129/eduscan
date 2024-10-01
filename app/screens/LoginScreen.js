import { SafeAreaView, View, StyleSheet, Button, Platform, Image, KeyboardAvoidingView, ScrollView, TouchableOpacity, Text } from "react-native";
import { useState, useContext } from "react";
import FormTextField from "../components/FormTextField";
import { login, loadUser } from "../services/AuthServices";
import AuthContext from "../contexts/AuthContexts";


export default function App({ navigation }) {
    const { setUser } = useContext(AuthContext);
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [errors, setErrors] = useState('');

    async function handleLogin() {
        setErrors({});
        try {
            await login({
                email,
                password,
                device_name: `${Platform.OS} ${Platform.Version}`,
            });

            const user = await loadUser();
            setUser(user);
        } catch (e) {
            console.log(e);
            if (e.response?.status === 422) {
                setErrors(e.response.data.errors);
            }
        }
    }

    return (
        <KeyboardAvoidingView
            behavior={Platform.OS === "ios" ? "padding" : "height"}
            className="flex-1 bg-blue-vtdt "
        >
            <ScrollView className="grow bg-blue-vtdt">
            <SafeAreaView className="flex-1 justify-center pt-5">
                    <View className="items-center">
                        <Image className="w-32 h-32"
                            source={require('../assets/vtdt.png')}
                        />
                    </View>
                    <View className="bg-white py-10 px-5 m-5 rounded-xl">
                    <Text className="font-bold pb-5 text-2xl text-center text-black">Login to EduScan</Text>

                        <FormTextField
                            label="Email address"
                            value={email}
                            onChangeText={(text) => setEmail(text)}
                            keyboardType="email-address"
                            errors={errors.email}
                        />
                        <FormTextField
                            label="Password"
                            secureTextEntry={true}
                            value={password}
                            onChangeText={(text) => setPassword(text)}
                            errors={errors.password}
                        />
                        <TouchableOpacity
                            className="bg-blue-600 py-3 rounded-md mt-6 shadow-lg mb-10"
                            onPress={handleLogin}
                        >
                            <Text className="text-white text-center font-bold text-lg">Login</Text>
                        </TouchableOpacity>
                        <TouchableOpacity
                            className=" py-3 rounded-md mt-6 mb-10"
                            onPress={() =>
                                navigation.navigate('Register')}
                        >
                            <Text className="text-blue-600 bg-transparent text-center text-lg">Create an account</Text>
                        </TouchableOpacity>

                    </View>
                </SafeAreaView>
            </ScrollView>
        </KeyboardAvoidingView>
    );
}

