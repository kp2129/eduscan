import { Text, View, TextInput, TouchableOpacity, StyleSheet } from "react-native";
import { Ionicons } from '@expo/vector-icons'; 
import { useState } from 'react';

export default function FormTextField({ label, secureTextEntry, errors = [], ...rest }) {
    const [isPasswordVisible, setIsPasswordVisible] = useState(secureTextEntry);

    return (
        <View className="mb-5">
            <View className="relative">
                <TextInput
                    className="h-12 bg-gray-100 pl-4 pr-10 rounded-md text-base focus:border-blue-500 focus:border"
                    placeholder={label} 
                    autoCapitalize="none"
                    placeholderTextColor='gray'
                    secureTextEntry={isPasswordVisible}
                    {...rest}
                />
                {secureTextEntry && (
                    <TouchableOpacity
                        onPress={() => setIsPasswordVisible(!isPasswordVisible)}
                        style={{
                            position: 'absolute',
                            right: 20,
                            top: '30%', 
                        }}
                    >
                        <Ionicons
                            name={isPasswordVisible ? 'eye-off' : 'eye'}
                            size={20}
                            color="gray"
                        />
                    </TouchableOpacity>
                )}
            </View>
            {errors.length > 0 && (
                <Text className="text-red mt-1 text-sm">{errors.join(", ")}</Text>
            )}
        </View>
    );
}
