import { SafeAreaView, View, Text, Image } from "react-native";
export default function App() {

    return (
        <SafeAreaView className="flex-1 justify-center items-center bg-vtdt">
            <View className="flex items-center">
                <Image className="w-32 h-32"
                    source={require('../assets/vtdt.png')}
                />
            </View>
        </SafeAreaView>
    );
}
