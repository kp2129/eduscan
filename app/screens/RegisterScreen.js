import { SafeAreaView, View, TouchableOpacity, Image, Text, Platform, KeyboardAvoidingView, ScrollView } from "react-native";
import { useState, useContext } from "react";
import FormTextField from "../components/FormTextField";
import { register, loadUser } from "../services/AuthServices";
import AuthContext from "../contexts/AuthContexts";

export default function RegisterScreen({ navigation }) {
    const { setUser } = useContext(AuthContext);
    const [name, setName] = useState('');
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [errors, setErrors] = useState({});
    const [passwordConfirmation, setPasswordConfirmation] = useState('');

    async function handleRegister() {
        setErrors({});

        try {
            await register({
                name,
                email,
                password,
                password_confirmation: passwordConfirmation,
                device_name: `${Platform.OS} ${Platform.Version}`,
            });

            const user = await loadUser();
            setUser(user);
            navigation.navigate("HomeTabs");
        } catch (e) {
            console.log(e);
            if (e.response?.status === 422) {
                setErrors(e.response.data.errors);
            }else{
                Alert.alert('Login Error', e.message || 'An error occurred during login.');
            }
        }
    }

    return (
        <KeyboardAvoidingView
            behavior={Platform.OS === "ios" ? "padding" : "height"}
            className="flex-1 bg-blue-vtdt"
        >
            <ScrollView className="grow">
                <SafeAreaView className="flex-1 justify-center pt-5 bg-blue-vtdt">
                    <View className="items-center">
                        <Image className="w-32 h-32"
                            source={require('../assets/vtdt.png')}
                        />
                    </View>
                    <View className="bg-white py-10 px-5 m-5 rounded-xl">
                        <Text className="font-bold pb-5 text-2xl text-center text-black">Sign Up to EduScan</Text>

                        <FormTextField
                            label="Name"
                            value={name}
                            onChangeText={(text) => setName(text)}
                            errors={errors.name}
                        />
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
                        <FormTextField
                            label="Password confirmation"
                            secureTextEntry={true}
                            value={passwordConfirmation}
                            onChangeText={(text) => setPasswordConfirmation(text)}
                            errors={errors.password_confirmation}
                        />
                        <TouchableOpacity
                            className="bg-blue-600 py-3 rounded-md mt-6 shadow-lg mb-10"
                            onPress={handleRegister}
                        >
                            <Text className="text-white text-center font-bold text-lg">Register</Text>
                        </TouchableOpacity>
                        <TouchableOpacity
                            className=" py-0 rounded-md mt-0  mb-10"
                            onPress={() => navigation.navigate('Login')}
                        >
                            <Text className="text-blue-600 text-center text-lg">Already have an account</Text>
                        </TouchableOpacity>
                    </View>
                </SafeAreaView>
            </ScrollView>
        </KeyboardAvoidingView>
    );
}
